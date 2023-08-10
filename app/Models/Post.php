<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function user(){
        // return $this hace referencia  la clase actual posts, y lo demás dice que pertenece a la clase user, y esto significa que un post pertenece a un usuario
        return $this->belongsTo(User::class);
    }

    // protected fillable tiene que ver con la protección de asignación masiva, pasar todos los datos de una solicitud a nuestro modelo puede ser riesgoso. Imaginemos que tenemos una pag donde los usuarios pueden editar sus perfiles, si  se pasara la solicitud completa al modelo. Un usuario podria editar cualquier columna que deseen como una columna del  tipo de si es administrador o no. Esto se denomina vulnerabilidad de asignación masiva. Laravel nos protege de esto al bloquear la asignación masiva de forma predeterminada, sin embargo la asignación masiva en muchos casos es conveniente ya que evita tener que asignar cada atributo uno por uno. P
    // Podemos activar la generación másiva de atributos marcandolos como fillable, rellenable
    // de esta manera estamos habilitando la asignacion masiva de los atributos title y body
    protected $fillable  = [
        'title',
        'body'
    ];
}
