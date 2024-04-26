<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Project;
use App\Models\Backer;
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
            return response()->json( $data );
        }
        else {
            return response()->json(['massege'=>' fail (wronge id)']);
        }
        
}

    
    public function addproject( Request $request,$user)
{
        $request->validate([
            'end_date'=>'required|numeric|between:1,60',
            'photos'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'second_photo'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'videos' => 'required|mimes:mp4,ogx,oga,ogv,ogg,webm',
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
        $project->photos= $image_name;
        $project->second_photo= $secondeimage_name;
        $project->videos= $video;
        $project->goal_amount= $request->goal_amount;
        $project->end_date = $request->end_date;
        $project->category = $request->category;
        $res = $project->save();
        
         return response()->json(['message'=>'project added succfully','user_data' => $project]);
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
        
    











}