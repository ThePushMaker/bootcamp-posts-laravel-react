import React from 'react';
// componentes importados de la ruta resources/js/Layouts o Components
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import InputError from '@/Components/InputError';
import PrimaryButton from '@/Components/PrimaryButton';
import { useForm, Head } from '@inertiajs/react';
import Post from '@/Components/Post';

// data recoge todos los datos que ponemos dentro del useForm. El metodo 'post' porque vamos a realizar un alta. processing, reset y errors que es para que una vez que mandamos los datos se limpien los campos, porque eso ya lo incluye este paquete de inertia
// dentro de useFormn van Las variables que vamos a manejar para el caso de un post
const Index = ({auth, posts}) => {
  const { data, setData, post, processing, reset, errors } = useForm({
    title: '',
    body: ''
  });

  const submit = (e) => {
    e.preventDefault();
    console.log(data);
    // tenemos que pasarle una ruta y hemos establecido que la ruta principal es posts y luego el metodo http que usaremos
    // onSuccess se refiere a lo que se hará una vez que se ejecute todo  ok  
    post(route('posts.store'), {onSuccess: () => reset() });
  }

  return (
    <AuthenticatedLayout auth={auth}>
      <Head title='Posts'/>
      <div className='max-w-2x1 mx-auto p-4 sm:p-6 lg:p-8'>
        <form onSubmit={submit}>
        {/* lo que vayamos capturando lo guardamos en title */}
          <input
            value={data.title}
            onChange={e => setData('title', e.target.value)}
            type= 'text'
            placeholder='Title'
            autoFocus
            className='mb-3 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm'
          />
          {/* input error es para que veamos los mensajes de validación que nuestro controlador de laravel los maneja. Por ejemplo si no ingresamos nada que nos muestre que este campo es requerido, el limite de caracteres, etc. */}
          <InputError message={errors.title} className='mt-2' />
          <textarea
            value={data.body}
            onChange={e => setData('body', e.target.value)}
            type='text'
            placeholder='Body'
            className='block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm'
          >
          </textarea>
          <InputError message={errors.title} className='mt-2' />
          {/* los estilos son de tailwind */}
          <PrimaryButton
            className='mt-4 text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2'
            disabled={processing}
            >
              Create
            </PrimaryButton>
        </form>
        <div className='mt-6 bg-indigo-400 rounded-lg divide-y-4 shadow-lg'>
          {
            posts.map( post =>
              <Post key={post.id} post={post}/>
              )}
        </div>
      </div>

    </AuthenticatedLayout>
  );
}
export default Index