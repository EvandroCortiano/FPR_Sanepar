<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Products;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\competencia;
use App\doador;
use App\repasse;
use App\sanepar_retorno;

class ProductsController extends Controller
{
    public function index(){
        return view('form');
    }
    public function upload(Request $request){
        $url = $request->file('url');
        $ext = ['jpg','png','jpeg','gif'];
        $extArq = $url->extension();
        if($url->isValid() && in_array($extArq, $ext)){
            $url->storeAs('img', $url->getClientOriginalName());
            
            $data = $request->all();
            $data['url'] = $url->getClientOriginalName();

            $product = Products::create($data);

            dd('Arquivo salvo no disco/banco');
        } 
        dd('não é valido');
        
    }

    public function importExport(){
        return view('importExport');
    }
    public function downloadExcel($type){
        // $data = Products::get()->toArray();
   
        $data = competencia::select('ddr_id as CÓDIGO - FPR','ddr_matricula as MATRICULA','ddr_nome as NOME DOADOR','doa_valor_mensal as VALOR MENSAL',
                             'doa_qtde_parcela as QNT. PARCELA','doa_motivo as MOTIVO','doa_valor as VALOR TOTAL','ddr_telefone_principal as TELEFONE')
                            ->leftJoin('cad_repasse','cre_cpa_id','cpa_id')
                            ->leftJoin('cad_doacao','doa_id','cre_doa_id')
                            ->leftJoin('cad_doador','ddr_id','doa_ddr_id')
                            ->get();

		return Excel::create('itsolutionstuff_example', function($excel) use ($data) {
			$excel->sheet('mySheet', function($sheet) use ($data)
	        {
				$sheet->fromArray($data);
	        });
		})->download($type);
    }
    
	public function importExcel(){
		if(Input::hasFile('import_file')){
            $path = Input::file('import_file')->getRealPath();
            //array para valores a ser gravado no banco de dados
            $data = array();
            //guarda possiveis erros
            $dataError = array();
            
            //ver a competencia
            $dataCom = Excel::selectSheetsByIndex(0)->load($path, function($reader){
                $reader->noHeading();
                $reader->takeRows(2);
                $reader->ignoreEmpty();
                $reader->takeColumns(4);
            })->get();
            //verifica se tem o valor da competencia
            if(!is_numeric($dataCom[0][0])){
                dd("Arquivo sem valor da competencia, favor verificar!");
            }
            //valida, pesquisa e salva a competencia
            if(!empty($dataCom) && $dataCom->count()){
                $cpa_id = competencia::find($dataCom[0][0]);
            } else {
                dd("Arquivo com o formato dos valores errados, favor verificar!");
            }

            //ver valores de retorno
            $dataReturn = Excel::selectSheetsByIndex(0)->load($path, function($reader){
                $reader->noHeading();
                $reader->takeColumns(11); //limita a quantidade de colunas
                $reader->skipRows(3); //pula a linha
                // $reader->ignoreEmpty(); //ignora os campos null
                // $reader->takeRows(6); //limita a quantidade de linha
            })->get();
             
            //cria dados para salvar na base de retorno sanepar
            if(!empty($dataReturn) && $dataReturn->count()){
                foreach($dataReturn as $ddr){
                    if($ddr[1] != null){
                        //pesquisa doador
                        $doador = doador::where('ddr_matricula',$ddr[2])->get();
                        if(!empty($doador) && $doador->count()){
                            //pesquisa se tem o doador na competencia requerida
                            $repasse = repasse::leftJoin('cad_doacao', 'doa_id', 'cre_doa_id')
                                            ->leftJoin('cad_doador', 'ddr_id', 'doa_ddr_id')
                                            ->where('cre_cpa_id', $cpa_id->cpa_id)
                                            ->where('ddr_id', $doador[0]->ddr_id)
                                            ->get();
                            // Cria data para salvar na tabel                  
                            if(!empty($repasse) && $repasse->count()){
                                $data[] = [
                                    'rto_cre_id' => $repasse[0]->cre_id,
                                    'rto_ddr_id' => $doador[0]->ddr_id,
                                    'rto_status' => $ddr[8],
                                    'rto_data_credito' => $ddr[9],
                                    'rto_valor_credito' => $ddr[10]
                                ]; 
                            }
                        } else {
                            dd("Doador (".$ddr[3].") não encontrado na base de dados de doadores, favor verificar!");
                        }
                    }
                }
            }
            
            // Salvar dados no banco
            if(!empty($data) && count($data)){
                foreach ($data as $dt){
                    try{
                        $cadSanepar = sanepar_retorno::create($dt);
                        if(!$cadSanepar){
                            dd("Não Gravou-Errror!".$dt['cre_ddr_id']);
                        }
                    } catch(\Exception $e){
                        return $e;
                    }
                }
            }
		}
		return back();
	}
}
