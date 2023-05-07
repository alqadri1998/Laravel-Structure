<?php

namespace App\Http\Libraries;

use Illuminate\Translation\Translator;

class SDTyresTranslator extends Translator {

    public function get($key, array $replace = array(), $locale = null, $fallback = true) {
        if (! isset($line)) {
            [$namespace, $group, $item] = $this->parseKey($key);
            $locales = $fallback ? $this->localeArray($locale) : [$locale];

            foreach ($locales as $locale) {
                if (! is_null($line = $this->getLine(
                    $namespace, $group, $locale, $item, $replace
                ))) {
                    return $line ?? $key;
                }
            }
        }

        $line = $key;
        return $this->makeReplacements($line ?: $key, $replace);
    }

}