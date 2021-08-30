<?php
require_once('../src/ReversTemplator.php');

function start_test(ReversTemplator $r, array $t)
{
    foreach ($t as $key => $value) {
        try {
            var_dump($r->getParams($value['template'],$value['string']));
        } catch (\Exception $exp) {
            echo $exp->getMessage();
            echo "\n";
        }
        
    }
}

$tests = array(
    array(
        'template'  => 'Hello, my name is {{name}}.',
        'string'    => 'Hello, my name is Juni.'
    ),
    array(
        'template'  => 'Hello, my name is {{name}.',
        'string'    => 'Hello, my name is Juni.'
    ),
    array(
        'template'  => 'Hello, my name is {{name}}',
        'string'    => 'Hello, my lastname is Juni.'
    ),
    array(
        'template'  => 'Hello, my name is {{name}}.',
        'string'    => 'Hello, my name is .'
    ),
    array(
        'template'  => 'Hello, my name is {name}.',
        'string'    => 'Hello, my name is <robot>.'
    ),
    array(
        'template'  => 'Hello, my name is {{name}}.',
        'string'    => 'Hello, my name is &lt;robot&gt;.'
    ),
);

$tests2 = array(
    array(
        'template'  => 'Hello, my name is [[name]].',
        'string'    => 'Hello, my name is Juni.'
    ),
    array(
        'template'  => 'Hello, my name is [[name].',
        'string'    => 'Hello, my name is Juni.'
    ),
    array(
        'template'  => 'Hello, my name is [[name]]',
        'string'    => 'Hello, my lastname is Juni.'
    ),
    array(
        'template'  => 'Hello, my name is [[name]].',
        'string'    => 'Hello, my name is .'
    ),
    array(
        'template'  => 'Hello, my name is [name].',
        'string'    => 'Hello, my name is <robot>.'
    ),
    array(
        'template'  => 'Hello, my name is [[name]].',
        'string'    => 'Hello, my name is &lt;robot&gt;.'
    )
);


$reversTemp = new ReversTemplator();
start_test($reversTemp,$tests);

echo "\n\nWith []:\n";
$reversTemp = new ReversTemplator('[',']');
start_test($reversTemp,$tests2);