<?php

namespace Mocking\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request; 

class Controller extends BaseController
{
    public function postData(Request $request) 
    {
        $postData = $request->all();
        $path = base_path().'/Mocking/Json/dataPesanan.json';
        $existingData = json_decode(file_get_contents($path), true);
        $combinedData = array_merge($existingData['pesanan'], $postData);
        file_put_contents($path, json_encode($combinedData, JSON_PRETTY_PRINT));
        return response()->json($existingData);
    }
    public function getData(Request $request) 
    {
       
        $path = base_path().'/Mocking/Json/dataPesanan.json';
        $existingData = json_decode(file_get_contents($path), true);
        return response()->json($existingData);
    }
    public function getMenu(Request $request) 
    {
       
        $path = base_path().'/Mocking/Json/MenuData.json';
        $existingData = json_decode(file_get_contents($path), true);
        return response()->json($existingData);
    }

public function putData(Request $request,$id) 
{
    $path = base_path().'/Mocking/Json/dataPesanan.json';
    $existingData = json_decode(file_get_contents($path), true);

   if (isset($existingData['pesanan']) || is_array($existingData['pesanan'])) {
        foreach ($existingData['pesanan'] as &$pesanan) {
            if ($pesanan['id'] == $id) {
                $pesanan['jumlah'] = $request->input('jumlah');
                $pesanan['subtotal'] = $request->input('subtotal');
                break; 
            }
        }
        file_put_contents($path, json_encode($existingData, JSON_PRETTY_PRINT));
        return response()->json($existingData);
    }

}
public function updateMenu(Request $request,$id) 
{
    $path = base_path().'/Mocking/Json/MenuData.json';
    $existingData = json_decode(file_get_contents($path), true);

   if (isset($existingData['data']) || is_array($existingData['data'])) {
        foreach ($existingData['data'] as &$data) {
            if ($data['id'] == $id) {
                    $data['stok'] -= intval($request->input('stok'));
                    break;
            }
        }
        file_put_contents($path, json_encode($existingData, JSON_PRETTY_PRINT));
        return response()->json($existingData);
    }

}
public function destroy(Request $request, $id)
{
    $path = base_path().'/Mocking/Json/dataPesanan.json';
    $existingData = json_decode(file_get_contents($path), true);
    if (isset($existingData['pesanan']) || is_array($existingData['pesanan'])) {
        $existingData['pesanan'] = array_filter($existingData['pesanan'], function ($pesanan) use ($id) {
            return $pesanan['id'] != $id;
        });
        file_put_contents($path, json_encode($existingData, JSON_PRETTY_PRINT));
    }
    return response()->json($existingData);
}
}