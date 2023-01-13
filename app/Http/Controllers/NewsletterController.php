<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsletterRequest;
use App\Http\Requests\UpdateNewsletterRequest;
use App\Models\Newsletter;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NewsletterController extends Controller {
  /**
   * Display a listing of the resource.
   *
   * @return View
   */
  public function index(): View {
    return view('newsletters.index', [
      'newsletters' => Newsletter::paginate(),
    ]);
  }
  
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create() {
    return view('newsletters.create');
  }
  
  /**
   * Store a newly created resource in storage.
   *
   * @param  StoreNewsletterRequest  $request
   *
   * @return RedirectResponse
   */
  public function store(StoreNewsletterRequest $request): RedirectResponse {
    $data = $request->validated();
    
    Newsletter::create($data);
    
    return redirect()->route("newsletters.index")
      ->with("success", "Newsletter creata correttamente");
  }
  
  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Newsletter  $newsletter
   *
   * @return \Illuminate\Http\Response
   */
  public function show(Newsletter $newsletter) {
    return view('newsletters.show', compact('newsletter'));
  }
  
  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Newsletter  $newsletter
   *
   * @return \Illuminate\Http\Response
   */
  public function edit(Newsletter $newsletter) {
    return view('newsletters.edit', compact('newsletter'));
  }
  
  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\UpdateNewsletterRequest  $request
   * @param  \App\Models\Newsletter                      $newsletter
   *
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateNewsletterRequest $request, Newsletter $newsletter) {
    //
  }
  
  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Newsletter  $newsletter
   *
   * @return \Illuminate\Http\Response
   */
  public function destroy(Newsletter $newsletter) {
    $newsletter->delete();
  
    return redirect()->route("newsletters.index")->with(["success" => "Newsletter eliminata correttamente!"]);
  }
}
