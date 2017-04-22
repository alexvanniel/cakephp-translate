<?php
namespace Translate\Filesystem;

use Cake\Core\Configure;
use Sepia\FileHandler;
use Sepia\PoParser;

class Dumper {

	/**
	 * @param \Translate\Model\Entity\TranslateTerm[] $translations
	 * @param string $domain
	 * @param string $lang
	 * @param string|null $folder
	 *
	 * @return bool
	 */
	public function dump(array $translations, $domain, $lang, $folder = null) {
		if ($folder === null) {
			$folder = LOCALE;
		}
		$folder .= $lang . DS;
		if (!is_dir($folder)) {
			mkdir($folder, 0770, true);
		}
		$file = $folder . $domain . '.po';
		if (!file_exists($file)) {
			touch($file);
		}

		$content = $this->_compile($translations, $file);

		return (bool)file_put_contents($file, $content);
	}

	/**
	 * @param \Translate\Model\Entity\TranslateTerm[] $translations $translations
	 * @param string $file
	 *
	 * @return string
	 */
	protected function _compile(array $translations, $file) {
		$max = Configure::read('Translate.plurals') ?: 2;
		$pluralExpression = Configure::read('Translate.pluralExpression') ?: 'n != 1';

		$po = new PoParser(new FileHandler($file));
		$newHeaders = [
			'"Project-Id-Version: \n"',
			'"POT-Creation-Date: \n"',
			'"PO-Revision-Date: \n"',
			'"Last-Translator: none\n"',
			'"Language-Team: \n"',
			'"MIME-Version: 1.0\n"',
			'"Content-Type: text/plain; charset=utf-8\n"',
			'"Content-Transfer-Encoding: 8bit\n"',
			'"Plural-Forms: nplurals=' . $max . '; plural=' . $pluralExpression . ';\n"'
		];

		$po->setHeaders($newHeaders);

		foreach ($translations as $translation) {
			$entry = [
				'msgid' => $translation->translate_string->name,
				'msgstr' => (string)$translation->content,
			];
			if ($translation->translate_string->plural !== null) {
				$entry['msgid_plural'] = $translation->translate_string->plural;
				$entry['msgstr[0]'] = (array)$entry['msgstr'];
				for ($i = 2; $i <= $max; $i++) {
					$pluralVersion = 'plural_' . $i;
					$entry['msgstr[' . ($i - 1) . ']'] = (array)(string)$translation->get($pluralVersion);
				}
			}
			if (!Configure::read('noComments')) {
				//$entry['comment'] =
			}

			if ($translation->translate_string->flags) {
				//$entry['flags'] = explode(',', $translation->translate_string->flags);
			}

			$po->setEntry($translation->translate_string->name, $entry);
			if ($translation->translate_string->plural !== null) {
				//$po->setEntryPlural($translation->translate_string->name, $entry['msgstr']);
			}
		}

		$content = $po->compile();

		return $content;
	}

}
