<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFaqRequest;
use App\Http\Requests\UpdateFaqRequest;
use App\Models\App;
use App\Models\Faq;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FaqController extends Controller {
  private function getAppsOptions() {
    $apps        = App::all();
    $appsOptions = [];
    
    foreach ($apps as $app) {
      $appsOptions[] = [
        "value" => $app->code,
        "text"  => $app->title
      ];
    }
    
    return $appsOptions;
  }
  
  /**
   * Display a listing of the resource.
   *
   * @return Application|Factory|View
   */
  public function index() {
    $faqs = Faq::orderBy("created_at", "desc")->paginate();
    
    return view('faqs.index', compact('faqs'));
  }
  
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create() {
    $appsOptions = $this->getAppsOptions();
    
    return view('faqs.create', compact("appsOptions"));
  }
  
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   *
   * @return \Illuminate\Http\Response
   */
  public function store(StoreFaqRequest $request) {
    $data = $request->validated();
    /**
     * @var User $user
     */
    $user = auth()->user();
    
    $faq = new Faq();
    $faq->fill($data);
    $faq->author = $user->_id;
    $faq->save();
    
    return redirect()->route("faqs.index")->with(["success" => "Faq creata correttamente"]);
  }
  
  /**
   * Display the specified resource.
   *
   * @param  Faq  $faq
   *
   * @return Application|Factory|View
   */
  public function show(Faq $faq) {
    return view('faqs.show', compact('faq'));
  }
  
  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   *
   * @return \Illuminate\Http\Response
   */
  public function edit(Faq $faq) {
    $appsOptions = $this->getAppsOptions();
    
    return view('faqs.edit', compact('faq', "appsOptions"));
  }
  
  /**
   * Update the specified resource in storage.
   *
   * @param  UpdateFaqRequest  $request
   * @param  Faq               $faq
   *
   * @return RedirectResponse
   */
  public function update(UpdateFaqRequest $request, Faq $faq) {
    $data = $request->validated();
    
    $faq->update($data);
    $faq->save();
    
    return redirect()->route("faqs.index")->with(["success" => "Faq aggiornata correttamente"]);
  }
  
  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   *
   * @return \Illuminate\Http\Response
   */
  public function destroy(Faq $faq) {
    $faq->delete();
    
    return redirect()->route("faqs.index")->with(["success" => "Faq eliminata correttamente!"]);
  }
}
