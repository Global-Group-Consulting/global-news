<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsletterRequest;
use App\Http\Requests\UpdateNewsletterRequest;
use App\Models\Newsletter;
use App\Models\NewsletterList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NewsletterController extends Controller {
  /**
   * Display a listing of the resource.
   *
   * @return View
   */
  public function index(): View {
    $data = Newsletter::with("list")
      ->paginate();
    
    $data->makeHidden(['content']);
    
    return view('newsletters.index', [
      'newsletters' => $data,
    ]);
  }
  
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create() {
    $lists = NewsletterList::all();
    
    return view('newsletters.create', compact('lists'));
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
    $lists = NewsletterList::all();
    
    return view('newsletters.edit', compact('newsletter', 'lists'));
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
    $data = $request->validated();
    
    $oldImages = collect($newsletter->images());
    $newImages = Str::matchAll('/(communicator\/wysiwyg(.*?)(?="))/', $data['content']);
    $diff      = $oldImages->diff($newImages);
    
    // before saving the new content, remove the old images that are not present anymore
    Storage::delete($diff->toArray());
    
    $newsletter->update($data);
    $newsletter->save();
    
    return redirect()->route("newsletters.index")
      ->with("success", "Newsletter modificata correttamente");
  }
  
  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Newsletter  $newsletter
   *
   * @return \Illuminate\Http\Response
   */
  public function destroy(Newsletter $newsletter) {
    // First remove the images from the storage
    Storage::delete($newsletter->images());
    
    $newsletter->delete();
    
    return redirect()->route("newsletters.index")->with(["success" => "Newsletter eliminata correttamente!"]);
  }
}
