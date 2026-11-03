<?php
namespace App\Http\Controllers;
use App\Models\{Venue,Service,Event,Client,Enquiry};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
class AdminController extends Controller {
 private const MAP=['venues'=>Venue::class,'services'=>Service::class,'events'=>Event::class,'clients'=>Client::class];
 public function dashboard(){return view('admin.dashboard',['stats'=>['Venues'=>Venue::count(),'Services'=>Service::count(),'Events'=>Event::count(),'Clients'=>Client::count(),'Enquiries'=>Enquiry::count()],'latest'=>Enquiry::latest()->take(8)->get()]);}
 private function model(string $section):string{abort_unless(isset(self::MAP[$section]),404);return self::MAP[$section];}
 public function index(string $section){$class=$this->model($section);return view('admin.index',['section'=>$section,'items'=>$class::latest()->paginate(15)]);}
 public function create(string $section){$this->model($section);return view('admin.form',['section'=>$section,'item'=>null]);}
 public function edit(string $section,int $id){$class=$this->model($section);return view('admin.form',['section'=>$section,'item'=>$class::findOrFail($id)]);}
 private function validated(Request $request,string $section,?int $id=null):array{
  if($section==='clients')return $request->validate(['name'=>'required|string|max:160','industry'=>'nullable|string|max:120','logo_url'=>'nullable|url:http,https|max:2000','sort_order'=>'nullable|integer|min:0','is_published'=>'required|boolean']);
  $common=['title'=>'required|string|max:180','summary'=>'nullable|string|max:450','description'=>'nullable|string|max:10000','image_url'=>'nullable|url:http,https|max:2000','sort_order'=>'nullable|integer|min:0','is_published'=>'required|boolean'];
  if($section==='venues')$common+=['type'=>'required|string|max:100','capacity_note'=>'nullable|string|max:120','features'=>'nullable|string|max:1000'];
  if($section==='services')$common+=['icon'=>'nullable|string|max:10'];
  if($section==='events')$common+=['status'=>'required|in:Upcoming,Past,Featured','event_date'=>'nullable|date','end_date'=>'nullable|date|after_or_equal:event_date'];
  return $request->validate($common);
 }
 private function normalize(array $data,string $section,?object $item=null):array{
  if($section!=='clients'){$data['slug']=Str::slug($data['title']);if($item && $item->slug!==$data['slug'])$data['slug'].='-'.time();}
  if($section==='venues'){$data['features']=array_values(array_filter(array_map('trim',explode(',',(string)($data['features']??'')))));}
  return $data;
 }
 public function store(Request $request,string $section){$class=$this->model($section);$data=$this->normalize($this->validated($request,$section),$section);$class::create($data);return redirect()->route('admin.items',['section'=>$section])->with('success','Item created.');}
 public function update(Request $request,string $section,int $id){$class=$this->model($section);$item=$class::findOrFail($id);$data=$this->normalize($this->validated($request,$section,$id),$section,$item);$item->update($data);return redirect()->route('admin.items',['section'=>$section])->with('success','Item updated.');}
 public function destroy(string $section,int $id){$class=$this->model($section);$class::findOrFail($id)->delete();return back()->with('success','Item deleted.');}
 public function enquiries(){return view('admin.enquiries',['items'=>Enquiry::latest()->paginate(25)]);}
 public function enquiry(Enquiry $enquiry){return view('admin.enquiry',['enquiry'=>$enquiry]);}
 public function enquiryUpdate(Request $request,Enquiry $enquiry){$data=$request->validate(['status'=>'required|in:New,Contacted,Quoted,Closed','admin_notes'=>'nullable|string|max:10000']);$enquiry->update($data);return back()->with('success','Enquiry saved.');}
}
