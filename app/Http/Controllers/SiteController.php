<?php
namespace App\Http\Controllers;
use App\Models\{Venue,Service,Event,Client,Enquiry};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class SiteController extends Controller {
 public function home(){return view('pages.home',['venues'=>Venue::where('is_published',true)->orderBy('sort_order')->take(3)->get(),'services'=>Service::where('is_published',true)->orderBy('sort_order')->take(6)->get(),'events'=>Event::where('is_published',true)->orderBy('event_date')->take(3)->get(),'clients'=>Client::where('is_published',true)->orderBy('sort_order')->take(8)->get()]);}
 public function venues(Request $request){$q=Venue::where('is_published',true)->orderBy('sort_order');if($request->filled('type')){$q->where('type',$request->query('type'));}return view('pages.venues',['venues'=>$q->get(),'types'=>Venue::where('is_published',true)->distinct()->pluck('type')]);}
 public function venue(Venue $venue){abort_unless($venue->is_published,404);return view('pages.venue',['venue'=>$venue]);}
 public function services(){return view('pages.services',['services'=>Service::where('is_published',true)->orderBy('sort_order')->get()]);}
 public function events(){return view('pages.events',['events'=>Event::where('is_published',true)->orderByRaw("CASE WHEN status = 'Upcoming' THEN 0 ELSE 1 END")->orderBy('event_date')->get()]);}
 public function clients(){return view('pages.clients',['clients'=>Client::where('is_published',true)->orderBy('sort_order')->get()]);}
 public function contact(){return view('pages.contact',['venues'=>Venue::where('is_published',true)->orderBy('title')->get()]);}
 public function enquiry(Request $request){
  // Honeypot + Laravel form CSRF, validation and per-IP throttling.
  $data=$request->validate(['name'=>'required|string|max:120','email'=>'required|email|max:190','phone'=>'required|string|max:40','organization'=>'nullable|string|max:180','interest'=>'required|in:Venue Rental,Meeting Hall,Event Services,General Enquiry','venue_id'=>'nullable|exists:venues,id','event_date'=>'nullable|date|after_or_equal:today','attendees'=>'nullable|integer|min:1|max:200000','message'=>'required|string|min:10|max:5000','website'=>'nullable|max:0']);
  unset($data['website']);$enquiry=Enquiry::create($data);
  if(config('slecc.enquiry_email')){try{Mail::raw('New SLECC enquiry #'.$enquiry->id."
From: ".$enquiry->name." <".$enquiry->email.">
Interest: ".$enquiry->interest."
Message: ".$enquiry->message,function($message){$message->to(config('slecc.enquiry_email'))->subject('New SLECC website enquiry');});}catch(\Throwable $e){report($e);}}
  return redirect()->route('contact')->with('success','Your enquiry has been received. Our team will review your request. This is not a confirmed booking.');
 }
}
