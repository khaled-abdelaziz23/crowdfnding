<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Project;
use App\Models\Backer;
use App\Models\Comment;
use App\Models\Complain;
use Illuminate\Http\Request;

class commentcontroller extends Controller
{
    public function allcomments()
    {
        $comments = Comment::get();
        return response()->json( $comments);
    }
    public function commenting(Request $request ,$user, $project)
    {
        $the_user = User::find($user);
        $the_project = Project::find($project);
        $comment = new Comment;
        $comment->comment_text = $request->comment_text;
        $comment->user_id =  $the_user->id;
        $comment->project_id = $the_project->id;
        $res = $comment->save();
        return response()->json(['message'=>'project added succfully','user_data' => $comment]);
    }
    public function usercomment($id)
    {
        $comment_user = Comment::with('user_comment')->find($id);
        if ($comment_user) {
            return response()->json( $comment_user );
        }
        else {
            return response()->json(['massege'=>' fail (wronge id)']);
        }
    }
    public function projectcomment($id)
{
    $comment_project = Comment::with('projects_comment')->find($id);
    if ($comment_project) {
        return response()->json( $comment_project );
    }
    else {
        return response()->json(['massege'=>' fail (wronge id)']);
    }
}

    public function deletecomment($id)
{
    $delete_comment = Comment::find($id);
    $delete_comment->delete();
    if ($delete_comment) {
        return response()->json( ['massege'=>' deleted successfully'] );
    }
    else {
        return response()->json(['massege'=>' fail (wronge id)']);
    }


}



















}