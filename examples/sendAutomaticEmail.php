<?php


require_once __DIR__ . '/../src/Trait/SingletonTrait.php';
require_once __DIR__ . '/../src/AutomaticEmailManagerRefactored.php';
require_once __DIR__ . '/../src/Model/AutomaticEmail.php';
require_once __DIR__ . '/../src/Model/AutomaticEmailTemplate.php';
require_once __DIR__ . '/../src/Model/Language.php';
require_once __DIR__ . '/../src/Model/Product.php';
require_once __DIR__ . '/../src/Model/User.php';

$automaticEmail = new AutomaticEmail(
    1,
    'You have a new booking request!',
    [
        new AutomaticEmailTemplate(
            <<<END
You have a new booking request!

Congratulations {%recipient_firstname}!

You have just received a booking request for your listing "{%product_title}".
\n
END,
            <<<END
See you soon,

The Click&Boat team
\n
END,
            new Language(1, 'en'),
            true
        )
    ]
);

$automaticEmailManager = new AutomaticEmailManager();
$automaticEmailManager->initialize(
    $automaticEmail,
    [
        'language_id' => 2,
        'recipient' => new User('Sophie', 'Stiquet', 'sophie.stiquet@clickandboat.com', '+33612345678'),
        'product' => new Product('Catamaran Lagoon 450F (refit 2020/21) 13.96m', 'Split', '450F', 'Lagoon')
    ],
    false
);
$display = $automaticEmailManager->build();
$automaticEmailManager->send($display);