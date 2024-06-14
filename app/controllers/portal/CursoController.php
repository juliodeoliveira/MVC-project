<?php
namespace app\controllers\portal;

use app\controllers\ContainerController;
use app\traits\View;

class CursoController extends ContainerController
{
    
    public function index() 
    {
        dd("Página principal de curso");
    }
    
    public function show($request)
    {
        $this->view([
            'title' => "Curso",
            'curso' => "PHP MVC"
        ], 'portal.curso');
    }

    public function create()
    {
        dd("Página de criação do curso");
    }

    public function store()
    {
        dd("O homi não explicou!! :O");
    }

    public function edit($id)
    {
        dd("Mostra formulário para atualizar registro");
    }

    public function update($id) 
    {
        dd("Atualiza registro do banco");
    }

    public function destroy($id)
    {
        dd("Deleta registro do banco ou ologout do sistema");
    }

}