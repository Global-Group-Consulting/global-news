<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsletterListRequest;
use App\Http\Requests\UpdateNewsletterListRequest;
use App\Models\NewsletterList;
use Illuminate\Http\Request;

class NewsletterListController extends Controller {
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    $newsletterLists = NewsletterList::paginate();
    
    return view('newsletter_lists.index', compact('newsletterLists'));
  }
  
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create() {
    return view('newsletter_lists.create');
  }
  
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   *
   * @return \Illuminate\Http\Response
   */
  public function store(StoreNewsletterListRequest $request) {
    $list = NewsletterList::create($request->validated());
    
    return redirect()->route('newsletter_lists.show', $list->id);
  }
  
  /**
   * Display the specified resource.
   *
   * @param  \App\Models\NewsletterList  $newsletterList
   *
   * @return \Illuminate\Http\Response
   */
  public function show(NewsletterList $newsletterList) {
    return view('newsletter_lists.show', compact('newsletterList'));
  }
  
  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\NewsletterList  $newsletterList
   *
   * @return \Illuminate\Http\Response
   */
  public function edit(NewsletterList $newsletterList) {
    return view('newsletter_lists.edit', compact('newsletterList'));
  }
  
  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request    $request
   * @param  \App\Models\NewsletterList  $newsletterList
   *
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateNewsletterListRequest $request, NewsletterList $newsletterList) {
    $newsletterList->update($request->validated());
    
    return redirect()->route('newsletter_lists.show', $newsletterList->id);
  }
  
  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\NewsletterList  $newsletterList
   *
   * @return \Illuminate\Http\Response
   */
  public function destroy(NewsletterList $newsletterList) {
    $newsletterList->delete();
    
    return redirect()->route('newsletter_lists.index');
  }
}
