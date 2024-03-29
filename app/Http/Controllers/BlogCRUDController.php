<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Blog;
use Datatables;
class BlogCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Blog::select('*'))
            ->addColumn('action', 'blog-action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('blogs');
    }
     
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        $blog_id = $request->id;
        $blog   =   Blog::updateOrCreate(
                    [
                     'id' => $blog_id
                    ],
                    [
                    'title' => $request->title, 
                    'detail' => $request->detail
                    ]);    
                        
        return Response()->json($blog);
    }
     
     
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {   
        $where = array('id' => $request->id);
        $blog  = Blog::where($where)->first();
     
        return Response()->json($blog);
    }
     
     
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $blog = Blog::where('id',$request->id)->delete();
     
        return Response()->json($blog);
    }
}