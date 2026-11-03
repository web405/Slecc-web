<?php
namespace Database\Seeders;
use App\Models\{User,Venue,Service,Event,Client};
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder {
 public function run():void {
  $email=env('SLECC_ADMIN_EMAIL'); $password=env('SLECC_ADMIN_PASSWORD');
  if($email && $password && strlen($password)>=12){ User::updateOrCreate(['email'=>$email],['name'=>env('SLECC_ADMIN_NAME','SLECC Admin'),'password'=>$password,'is_admin'=>true]); }
  $venues=[
   ['Exhibition & Trade Fair Hall','Exhibition Hall','An adaptable large-format venue for exhibitions, product showcases and trade fairs.','https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=1200&q=85'],
   ['Conference & Convention Space','Conference Hall','A flexible setting for presentations, panels, conventions and corporate gatherings.','https://images.unsplash.com/photo-1505373877841-8d25f7d46678?w=1200&q=85'],
   ['Meeting & Seminar Room','Meeting Hall','A focused environment for team sessions, workshops and business meetings.','https://images.unsplash.com/photo-1497366754035-f200968a6e72?w=1200&q=85'],
   ['Custom Event Space','Event Space','Discuss a tailored layout for launches, ceremonies, receptions and special occasions.','https://images.unsplash.com/photo-1511578314322-379afb476865?w=1200&q=85']
  ];foreach($venues as $i=>$a){Venue::updateOrCreate(['slug'=>Str::slug($a[0])],['title'=>$a[0],'type'=>$a[1],'summary'=>$a[2],'description'=>'Layout, technical specifications, availability and capacity are confirmed by the venue team during enquiry.','image_url'=>$a[3],'features'=>['Flexible formats','Custom setup','Enquiry-led booking'],'sort_order'=>$i,'is_published'=>true]);}
  $services=[
   ['Venue / Hall Rental','Explore flexible spaces designed to suit your event size, format and visitor experience.','https://images.unsplash.com/photo-1505373877841-8d25f7d46678?w=900&q=80','⌂'],
   ['Event Planning & Coordination','Coordinate schedules, suppliers, event flow and delivery milestones with an experienced team.','https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=900&q=80','▤'],
   ['Exhibition Stall Setup','Plan exhibition stands and booth layouts that make your brand easy to discover.','https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=900&q=80','▥'],
   ['Booth / Stand Construction','Create practical branded exhibition booths and display structures for your event.','https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=900&q=80','⬡'],
   ['Stage Setup','Prepare a flexible stage environment for presentations, launches and live productions.','https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?w=900&q=80','▱'],
   ['Audio-Visual & Technical Support','Support your audience experience with screen, projection and technical coordination.','https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=900&q=80','◉'],
   ['Sound & Lighting','Plan sound reinforcement and lighting suited to your programme and venue requirements.','https://images.unsplash.com/photo-1506157786151-b8491531f063?w=900&q=80','◈'],
   ['Registration / Reception Desk','Help guests arrive smoothly with organised check-in, reception and event information.','https://images.unsplash.com/photo-1559223607-a43c990c692c?w=900&q=80','☷'],
   ['Event Branding & Signage','Guide visitors and strengthen brand visibility with venue signage and branded touchpoints.','https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=900&q=80','▣'],
   ['Security & Crowd Management','Plan visitor access, flow and operational safety for a well-managed event.','https://images.unsplash.com/photo-1527525443983-6e60c75fff46?w=900&q=80','◇'],
   ['Cleaning & Waste Management','Coordinate event-day cleaning and responsible waste collection before and after use.','https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=900&q=80','♻'],
   ['Power & Electrical Facilities','Discuss temporary electrical requirements and power distribution for event production.','https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?w=900&q=80','ϟ'],
   ['Internet / Wi-Fi Facilities','Discuss visitor, exhibitor and organiser connectivity for your event.','https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=900&q=80','◎'],
   ['On-site Event Management','Get event-day coordination support to help suppliers and programme teams stay aligned.','https://images.unsplash.com/photo-1519167758481-83f550bb49b3?w=900&q=80','✧'],
  ];foreach($services as $i=>$a){Service::updateOrCreate(['slug'=>Str::slug($a[0])],['title'=>$a[0],'summary'=>$a[1],'description'=>$a[1].' Scope, fees, availability and inclusions are discussed in your quotation.','image_url'=>$a[2],'icon'=>$a[3],'sort_order'=>$i,'is_published'=>true]);}
  // No invented actual events, dates, clients, testimonials or venue capacities are seeded.
 }
}
