<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\App;
use App\Models\News;
use Illuminate\Http\Client\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Illuminate\View\View;

class NewsController extends Controller {
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
   * @return View
   */
  public function index(): View {
    $news = News::orderBy("created_at", "desc")->get();
    
    return view("news.index", [
      "news" => $news
    ]);
  }
  
  /**
   * Show the form for creating a new resource.
   *
   * @return View
   */
  public function create(): View {
    $appsOptions = $this->getAppsOptions();
    
    return view("news.create", compact("appsOptions"));
  }
  
  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\StoreNewsRequest  $request
   *
   * @return RedirectResponse
   */
  public function store(StoreNewsRequest $request): RedirectResponse {
    $data = $request->validated();
    
    $data["coverImg"] = $request->file("coverImg")->store("news", []);
    $data["content"]  = trim($data["content"]);
    
    News::create($data);
    
    return redirect()->route("news.index")->with(["status" => "News creata correttamente"]);
  }
  
  /**
   * Display the specified resource.
   *
   * @param  News  $news
   *
   * @return \Illuminate\Http\Response
   */
  public function show(News $news) {
    return view("news.show", compact("news"));
  }
  
  /**
   * Show the form for editing the specified resource.
   *
   * @param  News  $news
   *
   * @return View
   */
  public function edit(News $news): View {
    $appsOptions = $this->getAppsOptions();
    
    return view("news.edit", [
      "news"        => $news,
      "appsOptions" => $appsOptions
    ]);
  }
  
  /**
   * Update the specified resource in storage.
   *
   * @param  UpdateNewsRequest  $request
   * @param  News               $news
   *
   * @return RedirectResponse
   */
  public function update(UpdateNewsRequest $request, News $news): RedirectResponse {
    $data = $request->validated();
    
    if ($request->file("coverImg")) {
      // if already has an image, delete the current one and then upload the new one
      if ($news->coverImg) {
        Storage::delete($news->coverImg);
      }
      
      $data["coverImg"] = $request->file("coverImg")->store("news", []);
    }
    
    if ( !key_exists("active", $data)) {
      $data["active"] = 0;
    }
    
    $news->update($data);
    
    return redirect()->route("news.index")->with(["status" => "News aggiornata correttamente"]);
  }
  
  /**
   * Remove the specified resource from storage.
   *
   * @param  News  $news
   *
   * @return RedirectResponse
   */
  public function destroy(News $news): RedirectResponse {
    if ($news->coverImg) {
      Storage::delete($news->coverImg);
    }
    
    $news->delete();
    
    return redirect()->route("news.index")->with(["success" => "News eliminata correttamnte!"]);
  }
}
