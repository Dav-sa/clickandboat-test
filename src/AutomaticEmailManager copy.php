<?php

class AutomaticEmailManager
{
    private $automaticEmail;
    private $data;
    private $languages;
    private $isForPreview;

    public function initialize(AutomaticEmail $automaticEmail, array $data, $isForPreview,)
    {
        $this->automaticEmail = $automaticEmail;
        $this->data = $data;
        $this->isForPreview = $isForPreview;
    }
 

    public function build()
    {
        if (!$this->automaticEmail || (!$this->data && !$this->isForPreview)) {
            throw new LogicException(
                'AutomaticEmail not initialized (use `initialize` method or constructor to set the required information).'
            );
        }
        $this->initializeLanguages();
    
        $language = $this->getLanguage();
    
        $template = $this->getTemplate($language);
    
        if (!$this->isTemplateEnabled($template)) {
            return false;
        }
    
        $this->replaceToday($template);
    
        $this->replaceIntroduction($template);
    
        $this->replaceRecipientVars($template);
    
        $this->replaceProductVars($template);
    
        $this->replaceSignature($template);
    
        return $template;
    }

    private function initializeLanguages()
    {
    $this->languages = Language::getInstance()->all();
    }
    private function getLanguage()
    {
    $fallbackLanguage = Language::getInstance()->filterCode($this->languages, 'en');
    
        if (isset($this->data['language_id'])) {
            return Language::getInstance()->filterId($this->languages, $this->data['language_id'], true);
        } elseif (isset($this->data['recipient_account_id'])) {
            return Language::getInstance()->byAccountId($this->data['recipient_account_id']);
        } else {
            return $fallbackLanguage;
        }
    
    }



        
    private function replaceVar(string $var, string $value, string &$content)
    {
        $content = str_replace('{%' . $var . '}', $value, $content);
    }

    public function send($display)
    {
        echo $display->content . "\n";
        echo $display->signature . "\n";
    }
}