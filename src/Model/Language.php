<?php

class Language
{
    use SingletonTrait;

    public $id;
    public $code;

    public function __construct($id = null, $code = null)
    {
        $this->id = $id;
        $this->code = $code;
    }

    public function filterCode(array $languages, $languageCode)
    {
        foreach ($languages as $language) {
            if ($languageCode === $language->code) {
                return $language;
            }
        }

        return null;
    }

    public function filterId(array $languages, $id, $fallback = false)
    {
        foreach ($languages as $language) {
            if ($id === $language->id) {
                return $language;
            }
        }

        return null;
    }

    /**
     * @todo: DON'T MODIFY THIS METHOOD
     */
    public function all()
    {
        return [
            new Language(1, 'fr'),
            new Language(2, 'en'),
            new Language(3, 'es'),
            new Language(4, 'pt'),
        ];
    }

    /**
     * @todo: DON'T MODIFY THIS METHOOD
     */
    public function byAccountId($id)
    {
        return new Language(3, 'es');
    }
}