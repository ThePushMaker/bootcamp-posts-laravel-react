<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // acá gracias a eloquent podemos utilizar el metodo with sobre el modelo post, de esta manera  podemos traer el id y el nombre de usuario asociado a cada post. 
        // Tambien vemos como podemos utilizar el metodo latest() para devolver los registros en un orden cronologico inverso, es decir veremos primero los post más recientes a medida que se van agregando
        return Inertia::render('Posts/Index', [
            'posts' => Post::with('user:id,name')->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validamos los datos
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'body' => 'required|string|max:255'
        ]);

        // creamos la función posts(), alli crearemos la relación de posts y usuarios. Uno a mucho. Un usuario puede escribir muchos posts, pero un post solo puede pertenecer a un usuario. Estas relaciones se definen en los modelos
        $request->user()->posts()->create($validated);

        // redirigimos a la vista de blogs
        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        //validamos los datos
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'body' => 'required|string|max:255'
        ]);

        $post->update($validated);

        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // delete hace referencia al metodo que se encuentra en post policies, las politicas que habiamos creado
        // cuando ponemos el metodo autorize estamos hacindo referencia al metodo delete que se encuentra en las politicas de post 
        $this->authorize('delete', $post);
        
        $post->delete();

        return redirect(route('posts.index'));
    }
}
