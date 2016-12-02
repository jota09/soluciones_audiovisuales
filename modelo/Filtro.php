<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

      $request = new S3Request();
      $this->cargarCampos();
      $post = $request->obtenerVariables();
      if (isset($post['search']['value']) && $post['search']['value'] != '') {
         $where = '(';
         foreach ($this->camposTabla AS $c) {
            if (preg_match('/./', $c)) {
               $tmpC = explode('.', $c);
               $c = implode('`.`', $tmpC);
            }

            $where .= '`' . $this->table . '`.`' . $c . '` LIKE "%' . $post['search']['value'] . '%" OR ';
         }

         $where = substr($where, 0, -4) . ')';
         $bdObjeto->whereRaw($where);

       }
//         __P($this->camposTabla);

     foreach($filtro as $key=>$value){
      if (isset($post[$key][0]) && $post[$key][0] != '') {
         $whereAux = "";
         $where='';
         $fecha = explode("-", $post[$key]);
         if (checkdate($fecha[1], $fecha[2], $fecha[0])){
            $campo = intval(preg_replace('/[^0-9]+/', '', $key), 10);
            $where = '(`'.$value.'`.`'.$this->camposTabla[$campo].'` = "' . $post[$key] . '" )';
            $post[$key] = '';
         }
         if (isset($post[$key][1]) && $post[$key][1] != '' && !checkdate($fecha[1], $fecha[2], $fecha[0])) {
            foreach ($post[$key] as $modulo) {
               if ($modulo == "General") {
                  $whereAux = 'OR (`'.$value.'`.`id` > 0 ) ';
               } else {
                  $where .= "'" . $modulo . "',";
               }
            }
            $where = substr($where, 0, -1);
            $where = "(`".$value."`.`id` IN ( " . $where . " ) " . $whereAux . " )";
                       
         } else {
            if(!checkdate($fecha[1], $fecha[2], $fecha[0])) {
            if ($post[$key][0] === "General" || $post[$key][0] === "") {
               $where = '(`'.$value.'`.`id` > 0 )';
            } else {
               
               $where = '(`'.$value.'`.`id` = ' . $post[$key][0] . ' )'; 
               
            }
            }
         }
//         __P($where);
         $bdObjeto->whereRaw($where);
 
         
            } 
            
            }
      
         $tmpObj = clone $bdObjeto;
         $this->cantFil = $tmpObj->count();

      $this->modObtenerListaRegistrosAjaxTabla($bdObjeto);
      $bdObjeto->take($post['length'])->skip($post['start']);

