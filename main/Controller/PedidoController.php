<?php 

namespace main\Controller\PedidoController;

Use main\Models\Entidade\Pedido;
use main\Models\DAO\BaseDAO;

class PedidoController extends BaseDAO{

    public  function listar($id = null)    {
        if($id) {
            $resultado = $this->select(
                "SELECT * FROM controlePedido WHERE codControle = $id"
            );

            return $resultado->fetchObject(Pedido::class);
        }else{
            $resultado = $this->select(
                "SELECT * FROM controlePedido"
            );
            return $resultado->fetchAll(\PDO::FETCH_CLASS, Pedido::class);
        }

        return false;
    }




}

?>