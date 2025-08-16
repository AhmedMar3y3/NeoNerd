<?php

namespace App\Traits;

trait HasLocalizedEnum
{
    public function getLocalizedName(): string
    {
        $enumName = strtolower(class_basename($this));
        $key = $this->value;
        
        $translationKey = "enums.{$enumName}s.{$key}";
        $translation = __($translationKey, [], 'ar');
        
        // If translation is the same as the key, return a fallback
        if ($translation === $translationKey) {
            return $this->getFallbackName();
        }
        
        return $translation;
    }
    
    private function getFallbackName(): string
    {
        $enumName = strtolower(class_basename($this));
        $key = $this->value;
        
        // Manual fallback translations
        $fallbacks = [
            'academiclevel' => [
                'university' => 'جامعي',
                'secondary' => 'ثانوي',
            ],
            'subjecttype' => [
                'scientific' => 'علمي',
                'literal' => 'أدبي',
                'both' => 'علمي وأدبي',
            ],
            'term' => [
                'first' => 'الفصل الأول',
                'second' => 'الفصل الثاني',
            ],
            'secondarytype' => [
                'arabic' => 'عربي',
                'language' => 'لغات',
            ],
            'secondarygrade' => [
                'first' => 'الأول',
                'second' => 'الثاني',
                'third' => 'الثالث',
            ],
            'secondarysection' => [
                'literal' => 'أدبي',
                'scientific' => 'علمي',
            ],
            'gender' => [
                'male' => 'ذكر',
                'female' => 'أنثى',
            ],
            'scientificbranch' => [
                'science' => 'علوم',
                'math' => 'رياضيات',
            ],
        ];
        
        return $fallbacks[$enumName][$key] ?? $key;
    }
    
    public static function getLocalizedOptions(): array
    {
        $options = [];
        $enumName = strtolower(class_basename(new \ReflectionClass(static::class)));
        
        foreach (static::cases() as $case) {
            $options[$case->value] = $case->getLocalizedName();
        }
        
        return $options;
    }
}
