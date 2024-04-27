<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Project;
use App\Models\Backer;
use App\Models\Complain;
use Illuminate\Http\Request;


class projectcontroller extends Controller
{
      public function allproject()
    {
        $allprojects = Project::get();
        return response()->json($allprojects);
    }
    
    
    public function getproject($id)
    {
        $data = User::with('projects')->find($id);
    
        // $titlss=$data->projects; 
        // foreach ($titlss as $titles ){
        //     echo $titles->title . '<br>'; 
        //     echo $titles->user_id . '<br>'; 
        // }
        if ($data) {
            return response()->json(['user_data' => $data]);
        }
        else {
            return response()->json(['massege'=>' fail (wronge id)']);
        }
        
    }
    public function justproject($id)
    {
        $data = Project::find($id) ;
       
        return response()->json($data);
        
    }
    public function addproject( Request $request,$user)
    {
        $request->validate([
            'end_date'=>'required|numeric|between:1,60',
            'photos'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
            'second_photo'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
            'videos' => 'required|mimes:mp4,ogx,oga,ogv,ogg,webm|max:30240',
            ]);
        #project_photo
        $image_name = rand() . '.' .$request->photos->getClientOriginalExtension(); 
        $request->photos->move(public_path('/images/projectphoto'),$image_name);
        #second_project_photo
        $secondeimage_name = rand() . '.' .$request->second_photo->getClientOriginalExtension(); 
        $request->second_photo->move(public_path('/images/projectsecondphoto'),$secondeimage_name);
        #project_video
        $video = rand() . '.' .$request->videos->getClientOriginalExtension(); 
        $request->videos->move(public_path('/videos'),$video);

        $the_user = User::find($user);
        $project = new Project;
        $project->user_id = $the_user->id;
        $project->title= $request->title;
        $project->description= $request->description;
        $project->photos = asset('images/projectphoto/' . $image_name); 
        $project->second_photo = asset('images/projectsecondphoto/' . $secondeimage_name); 
        $project->videos = asset('videos/' . $video); 
        $project->goal_amount= $request->goal_amount;
        $project->end_date = $request->end_date;
        $project->category = $request->category;
        $res = $project->save();
        
          return response()->json(['message'=>'project added succfully','user_data' => $project]);
        
           
        }
        public function editproject(Request $request,$id)
{ 
    $project = Project::find($id);
    if ( $project->acceptans == 0) {
       
    // $request->validate([
    //     'end_date'=>'numeric|between:1,60',
    //     'photos'=>'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
    //     'second_photo'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //     'videos' => 'mimes:mp4,ogx,oga,ogv,ogg,webm',
    //     ]);
    #project_photo
    $image_name = rand() . '.' .$request->photos->getClientOriginalExtension(); 
    $request->photos->move(public_path('/images/projectphoto'),$image_name);
    #second_project_photo
    $secondeimage_name = rand() . '.' .$request->second_photo->getClientOriginalExtension(); 
    $request->second_photo->move(public_path('/images/projectsecondphoto'),$secondeimage_name);
    #project_video
    $video = rand() . '.' .$request->videos->getClientOriginalExtension(); 
    $request->videos->move(public_path('/videos'),$video);

    $project = Project::find($id);
    $project->title= $request->title;
    $project->description= $request->description;
    $project->photos = asset('images/projectphoto/' . $image_name); 
    $project->second_photo = asset('images/projectsecondphoto/' . $secondeimage_name); 
     $project->videos = asset('videos/' . $video); 
    $project->goal_amount= $request->goal_amount;
    $project->end_date = $request->end_date;
    $project->category = $request->category;
    $res = $project->save();
    return response()->json(['message'=>'project updated succfully','user_data' => $project]);

}
}

     public function deleteproject($id)
     {
        $data = Project::find($id);
        $image_path = public_path('/images/projectphoto/'.$data->photos);
        $secondeimage_path = public_path('/images/projectsecondphoto/'.$data->second_photo);
        $videoo = public_path('videos/'.$data->videos);
    
        if (file_exists($image_path)) {

           unlink($image_path);
        }
        if (file_exists($secondeimage_path)) {

           unlink($secondeimage_path);
        }
        if (file_exists($videoo)) {

           unlink($videoo);
        }
        if($data){
            $data->delete();
           return response()->json([
            'status' => 'success',
            'message' => 'user deleted successfully',
        ]);
        }
        else {
        return response()->json([
            'status' => 'error',
            'message' => 'user not found (id is wrong)',
        ]);
     }   
    }
     public function decrease()
    {
        $projects = Project::where('acceptans', 1)->get();
        

            foreach ($projects as $project) {
                $project->end_date -=1;
                $project->save();
            }
            return response()->json([
                    'status' => 'success',
                    'message' => 'Number decreased successfully!',
                ]);
        }
        
     public function collectedmoney()
{
    $projects = Project::get();

    foreach ($projects as $project) {
        // Get backers for this project
        $backers = Backer::where('project_id', $project->id)->where('pledge_amount', '>', 0)->get();

        // Calculate total collected money for this project
        $collected_money = $backers->sum('pledge_amount');

        // Update or create project record with collected money
        $project->update(['collected_money' => $collected_money]);
       
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Collected money stored successfully!',
    ]);
}
   public function backer($id)
{
    $data = Backer::with('projects_backer')->find($id);
    if ($data) {
        return response()->json( $data );
    }
    else {
        return response()->json(['massege'=>' fail (wronge id)']);
    }
}
public function userbacker($id)
{
    $data = Backer::with('user_backer')->find($id);
    if ($data) {
        return response()->json( $data );
    }
    else {
        return response()->json(['massege'=>' fail (wronge id)']);
    }
} 
public function backproject(Request $request ,$user, $project)
{
    $the_user = User::find($user);
    $the_project = Project::find($project);
    $backer = new Backer;
    $backer->pledge_amount = $request->pledge_amount;
    $backer->user_id =  $the_user->id;
    $backer->project_id = $the_project->id;
    $res = $backer->save();
    return response()->json(['message'=>' you backed succfully','user_data' => $backer]);
}
public function allbacker()
{
    $allbacker = Backer::get();
    return response()->json($allbacker);
}
public function allcomplain()
{
    $allbacker = Complain::get();
    return response()->json($allbacker);
}
public function addcomplain(Request $request ,$user )
{
    $the_user = User::find($user);
    $complain = new Complain;
    $complain->complaint_title = $request->complaint_title;
    $complain->description = $request->description;
    $complain->user_id =$the_user->id;
    $res = $complain->save();
    return response()->json(['message'=>'project added succfully','user_data' => $complain]);
}
public function complaintuser($id)
{
    $complaint_user = Complain::with('users_complaint')->find($id);
    if ($complaint_user) {
        return response()->json( $complaint_user );
    }
    else {
        return response()->json(['massege'=>' fail (wronge id)']);
    }
}
public function deletecomplaint($id)
{
    $complaint = Complain::find($id);
    if ($complaint->is_solved == 'Not_solved') {
        
        $complaint->delete();
        return response()->json(['massege'=>' complaint deleted successfully']);
    }
}




}