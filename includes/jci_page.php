<?php

//seguridad
defined('ABSPATH') or die('No se admiten trampas');

function jci_calculator(){
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>

        <h1 class="wrap"><b><i>Bienvenido a su calculadora</i></b></h1><br>
        <table>
            <tr>
                <td>
                    <input type="number" id="op1" placeholder="Operando 1">
                </td>
                <td>
                    <select name="signo" id="signo">
                        <option value="+">+
                        </option>
                        <option value="-">-
                        </option>
                        <option value="*">*
                        </option>
                        <option value="/">/
                        </option>
                    </select>
                </td>
                <td>
                    <input type="number" id="op2" placeholder="Operando 2">
                </td>
                <td>
                    <button onclick="calcular();">Calcular</button>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo "<h4>Resultado: </h4>"?> <input type="text" id="resultado" readonly>
                </td>
            </tr>
        </table>

        <script>
            function calcular(){

                let n1 = parseInt($('#op1').val());
                let n2 = parseInt($('#op2').val());
                let signo = $('#signo').val();
                let resultado;

              

                if(isNaN(n1) || isNaN(n2)){
                    resultado = "Ingrese dos operandos";
                }else if(signo == "+"){
                    resultado = n1 + n2;
                }else if(signo == "-"){
                    resultado = n1 - n2;
                }else if(signo == "*"){
                    resultado = n1 * n2;
                }else if(signo == "/"){
                    resultado = n1 / n2;
                }

                $('#resultado').val(resultado);

            }
        </script>

        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    </body>
    </html>

    

    <?php
}

?>