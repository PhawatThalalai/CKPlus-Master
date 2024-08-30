<?php

namespace App\Http\Controllers\backend;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportBuilderController extends Controller
{
   
    public function index()
    {
        $client = new Client();
        $response = $client->get('https://ckl.co.th/assets/images/branch.rdl');

        $html = (string) $response->getBody();

        return view('backend.content-report.reportBuilder.test', ['reportBuilderHtml' => $html]);
    }

  
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        //
    }

   
    public function show($id)
    {
        //
    }

  
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        //
    }

  
    public function destroy($id)
    {
        //
    }
}
