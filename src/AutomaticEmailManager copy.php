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

    private function getTemplate($language)
    {
        return array_filter(
            $this->automaticEmail->templates,
            fn($template) => $template->language->code === $language->code
    )[0];
    }
        
    private function isTemplateEnabled($template)
    {
        return (!isset($template->isEnabled) || !$template->isEnabled) && !$this->isForPreview;
    }

    private function replaceToday($template)
    {
    $this->replaceVar('today', (new DateTime())->format('d/m/Y'), $template->content);
    }

    private function replaceIntroduction($template)
    {
        if (isset($this->params['introduction'])) {

    $this->replaceVar('introduction', str_replace("\n", '<br>', $this->params['introduction']), $template->content);
    }
    }

    private function replaceRecipientVars($template)
    {
        if (isset($this->data['recipient'])) {
    $prefix = 'recipient';
    
            $this->replaceVar($prefix . '_firstname', $this->data['recipient']->firstName, $template->content);
            $this->replaceVar($prefix . '_name', $this->data['recipient']->lastName, $template->content);
            $this->replaceVar($prefix . '_email', $this->data['recipient']->email, $template->content);
            $this->replaceVar($prefix . '_phone', $this->data['recipient']->phone, $template->content);
        }
    
    }

    private function replaceProductVars($template)
    {
        if (isset($this->data['product'])) {
    $prefix = 'product';
    
            $this->replaceVar($prefix . '_title', $this->data['product']->title, $template->content);
            $this->replaceVar($prefix . '_city', $this->data['product']->city, $template->content);
            $this->replaceVar($prefix . '_model', $this->data['product']->model, $template->content);
            $this->replaceVar($prefix . '_builder', $this->data['product']->builder, $template->content);
        }
    
    }
    private function replaceSignature($template)
    {
        if (isset($this->params['signature'])) {
    if ($this->params['signature'] === true) {
                if (isset($data['sender']) && null !== $language) {
                    $this->params['signature'] = Translator::getInstance()->translate($language, 'DefaultAutomaticEmailSignature');
    } else {
    $this->params['signature'] = '';
    }
    }
    
            $this->replaceVar('signature', str_replace("\n", '<br>', $this->params['signature']), $template->signature);
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