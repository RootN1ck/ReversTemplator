# ReversTemplator
Как использовать:

инициализация

    //простая инициализация
    $reversTemp = new ReversTemplator();
   
    //с указание токенов (открывающий, закрывающий) - должны быть разными иначе будут использоваться токены поумолчанию -{ }
    $reversTemp = new ReversTemplator('[',']');
    
    
получение параметров - принимает строку шаблона и строку результата; возвращает массив параметров или выбрасывает исключение

    $reversTemp->getParams('Hello, my name is {{name}}.','Hello, my name is Juni.');

Задача

Необходимо реализовать инструмент для "обратной шаблонизации", который на основе строки результата и шаблона восстанавливает переменные, необходимо реализовать валидацию и учесть граничные условия.

На вход подаются шаблон и результат, на выходе ожидается массив переменных

    шаблон Hello, my name is {{name}}. результат Hello, my name is Juni. -> ['name' => "Juni"]
    шаблон Hello, my name is {{name}. результат Hello, my name is Juni. -> throw new InvalidTemplateException('Invalid template.')
    шаблон Hello, my name is {{name}}. результат Hello, my lastname is Juni. -> throw new ResultTemplateMismatchException('Result not matches original template.')
    шаблон Hello, my name is {{name}}. результат Hello, my name is . -> ['name' => ""]
    шаблон Hello, my name is {name}. результат Hello, my name is <robot>. -> ['name' => "<robot>"]
    шаблон Hello, my name is {{name}}. результат Hello, my name is &lt;robot&gt;. -> ['name' => "<robot>"]

Реализованное решение необходимо выложить в публичный репозиторий на github и прислать ссылку. Текст этого задания может быть дополнен ответами или пояснениями на ваши вопросы. В README.md должен содержаться пример использования.
Преимущество при выполнении работы дает:

    наличие тестов
    возможность параметризации шаблонизатора (напр. возможность поменять токен с {{ на [[) либо другие "ручки" на ваше усмотрение
    комментарии по мере необходимости
