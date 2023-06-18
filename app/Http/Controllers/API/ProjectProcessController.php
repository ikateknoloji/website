<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProjectProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProjectProcessController extends Controller
{
    /**
     * Tüm proje işlemlerini getirir.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $processes = ProjectProcess::select('id','title', 'content', 'image_path')->get(); // Tüm proje işlemlerini getirir
        return response()->json($processes, 200); // Proje işlemlerini JSON yanıtı olarak döndürür
    }

    /**
     * Yeni bir proje işlemi oluşturur.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'content' => 'required|string',
            'image_path' => 'required|image'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400); // Geçersiz istek durumunda hataları JSON yanıtı olarak döndürür
        }

        $image = $request->file('image_path');
        // Benzersiz bir isim oluştur
        $image_name = uniqid() . '.' . $image->getClientOriginalExtension(); 
        $image_path = $image->storeAs('project_processes', $image_name, 'public'); // Resmi 'public' diskindeki 'project_processes' klasörüne kaydet
    

        // Yeni proje işlemini oluşturur
        $projectProcess = ProjectProcess::create([
            'title' => $request->title,
            'content' => $request->content,
            'image_path' => $image_path,
        ]); 

        return response()->json($projectProcess->only('id','title', 'content', 'image_path'), 201); // Oluşturulan proje işlemini JSON yanıtı olarak döndürür
    }

    /**
     * Belirli bir proje işlemini getirir.
     *
     * @param  \App\Models\ProjectProcess  $projectProcess
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectProcess $projectProcess)
    {
        // Belirli proje işlemini JSON yanıtı olarak döndürür
        return response()->json($projectProcess, 200); 
    }

    /**
     * Belirli bir proje işlemini günceller.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectProcess  $projectProcess
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string',
            'content' => 'sometimes|string',
            'image_path' => 'sometimes|image'
        ]);

        $projectProcess = ProjectProcess::findOrFail($id);

        if ($validator->fails()) {
            // Geçersiz istek durumunda hataları JSON yanıtı olarak döndürür
            return response()->json($validator->errors(), 400); 
        }



        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            // Benzersiz bir isim oluştur
            $image_name = uniqid() . '.' . $image->getClientOriginalExtension(); 
            // Resmi 'public' diskindeki 'project_processes' klasörüne kaydet
            $image_path = $image->storeAs('project_processes', $image_name, 'public'); 
           
            Storage::disk('public')->delete($projectProcess->image_path);  // Eski resmi sil
            $projectProcess->image_path = $image_path;  // Yeni resmin yolunu kaydet
        }
        // Başlığı güncelle, eğer değer yoksa mevcut değeri koru
        $projectProcess->title = $request->input('title', $projectProcess->title); 
        // İçeriği güncelle, eğer değer yoksa mevcut değeri koru
        $projectProcess->content = $request->input('content', $projectProcess->content); 
        $projectProcess->save(); // Değişiklikleri kaydet

        // Güncellenmiş proje işlemini JSON yanıtı olarak döndürür
        return response()->json($projectProcess->only('id','title', 'content', 'image_path'), 200); 
    }

    /**
     * Belirli bir proje işlemini siler.
     *
     * @param  \App\Models\ProjectProcess  $projectProcess
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectProcess $projectProcess)
    {
        Storage::disk('public')->delete($projectProcess->image_path); // İlgili resmi sil
        $projectProcess->delete(); // Proje işlemi kaydını sil

        return response()->json(null, 204); // Başarılı yanıt, içerik olmadığı için 204 No Content döndürür
    }
}
