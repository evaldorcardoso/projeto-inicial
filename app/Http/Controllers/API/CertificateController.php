<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CertificateStoreRequest;
use Illuminate\Http\Request;
use App\Models\Certificate;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use phpseclib3\File\ASN1\Maps\RDNSequence;
use App\Seclib\phpSeclib;
//use phpseclib3\File\X509;
//include_once('../../../SecLib/SecLib.php');

use function PHPSTORM_META\type;

class CertificateController extends Controller
{
    /**
     * Exibe os certificados registrados para o usuário logado
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $certificates = auth()->user()->certificates;

            return response()->json([
                'success' => true,
                'data' => $certificates
            ]);
        }catch(\Exception $e){
            Log::error('Não foi possível listar os certificados: '.$e->getMessage());
            return response(['message' => 'Não foi possível listar os certificados']);
        }
    }

    /**
     * Registra um novo certificado no banco de dados.
     *
     * @param  App\Http\Requests\CertificateStoreRequest;  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CertificateStoreRequest $request)
    {    
        try{
            $input = $request->all();
            if($request->hasFile('file')){
                $nameFile = Str::of($request->dn)->slug('-').'.'.$request->file->getClientOriginalExtension();
                $path = $request->file->storeAs('public/files', $nameFile);
                $input['filename']=$path;                
                //ler os dados do certificado
                $cert = new phpSeclib(Storage::path($input['filename']));                
                $input['expiration_date'] = $cert->getExpirationDate();
                $input['dn'] = $cert->getDN();
                $input['issuer_dn'] = $cert->getIssuerDN();
            }        
            $input['user_id'] = auth()->user()->id;
            
            $certificate = Certificate::create($input);

            Log::info('Novo certificado registrado com sucesso! '.$certificate->id);
            return response()->json([
                'success' => true,
                'data' => $certificate->toArray()
            ]);
        }catch(\Exception $e){
            Log::error('Não foi possível cadastrar o certificado: '.$e->getMessage());
            return response(['message' => 'Não foi possível cadastrar o certificado. '.$e->getMessage()]);
        }
    }

    /**
     * Exibe os dados do certificado solicitado
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $certificate = auth()->user()->certificates()->find($id);

            if(! $certificate){
                return response()->json([
                    'success' => false,
                    'message' => 'Certificado nao encontrado'
                ], 400);
            }
            
            return response()->json([
                'success' => 200,
                'data' => $certificate->toArray()
            ], 200);
        }catch(\Exception $e){
            Log::error('Não foi possível exibir o certificado '.$id.': '.$e->getMessage());
            return response(['message' => 'Não foi possível exibir o certificado solicitado '.$e->getMessage()]);
        }
    }

    /**
     * Atualiza os dados do certificado.
     *
     * @param  App\Http\Requests\CertificateStoreRequest;  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CertificateStoreRequest $request, $id)
    {
        try{
            $certificate = auth()->user()->certificates()->find($id);
            
            if (!$certificate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Certificado nao encontrado'
                ], 400);
            }
            $input = $request->all();            
            if($request->hasFile('file')){
                if(Storage::exists($certificate->filename))
                    Storage::delete($certificate->filename);
                $nameFile = Str::of($request->dn)->slug('-').'.'.$request->file->getClientOriginalExtension();
                $path = $request->file->storeAs('public/files', $nameFile);
                $input['filename']=$path;                
                //ler os dados do certificado
                $cert = new phpSeclib(Storage::path($input['filename']));                
                $input['expiration_date'] = $cert->getExpirationDate();
                $input['dn'] = $cert->getDN();
                $input['issuer_dn'] = $cert->getIssuerDN();
            }  
    
            $updated = $certificate->fill($input)->save();

            if(! $updated){
                return response()->json([
                    'success' => false,
                    'message' => 'Nao foi possivel atualizar o certificado'
                ], 500);
            }

            Log::info('certificado atualizado com sucesso! '.$certificate->id);
            return response()->json([
                'success' => true
            ]);
        }catch(\Exception $e){
            Log::error('Não foi possível atualizar o certificado '.$id.': '.$e->getMessage());
            return response(['message' => 'Não foi possível atualizar o certificado']);
        }
    }

    /**
     * Remove o certificado do banco de dados.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $certificate = auth()->user()->certificates()->find($id);
    
            if (!$certificate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Certificado nao encontrado'
                ], 400);
            }

            if(Storage::exists($certificate->filename))
                Storage::delete($certificate->filename);

            if(! $certificate->delete()){
                return response()->json([
                    'success' => false,
                    'message' => 'Nao foi possivel excluir o certificado'
                ], 500);
            }

            Log::info('certificado excluído com sucesso! '.$id);
            return response()->json([
                'success' => true
            ]); 
        }catch(\Exception $e){
            Log::error('Não foi possível excluir o certificado '.$id.': '.$e->getMessage());
            return response(['message' => 'Não foi possível excluir o certificado']);
        }
    }
}
