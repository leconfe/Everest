<?php

namespace Everest;

use App\Classes\Theme;

use App\Facades\Hook;
use App\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Forms\Components\TinyEditor;
use Filament\Forms\Components\ColorPicker;
use luizbills\CSS_Generator\Generator as CSSGenerator;
use matthieumastadenis\couleur\ColorFactory;
use matthieumastadenis\couleur\ColorSpace;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Blade;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

class EverestTheme extends Theme
{
	public function boot()
	{
		if (app()->getCurrentScheduledConference()?->getMeta('theme') == 'Everest') {
            Blade::anonymousComponentPath($this->getPluginPath('resources/views/frontend/website/components'), prefix: 'website');
            Blade::anonymousComponentPath($this->getPluginPath('resources/views/frontend/scheduledConference/components'), prefix: 'scheduledConference');
        }
		Blade::anonymousComponentPath($this->getPluginPath('resources/views/frontend/website/components'), 'everest');
	}

	public function getFormSchema(): array
	{
		return [
			Toggle::make('top_navigation')
				->label('Enable Top Navigation')
				->default(false),
			SpatieMediaLibraryFileUpload::make('images')
				->collection('everest-header')
				->label('Upload Header Images')
				->multiple()
				->maxFiles(4)
				->image()
				->conversion('thumb-xl'),
			ColorPicker::make('appearance_color')
				->regex('/^#?(([a-f0-9]{3}){1,2})$/i')
				->label(__('general.appearance_color')),

			// Layouts
			Builder::make('layouts')
				->collapsible()
				->collapsed()
				->cloneable()
				->blockNumbers(false)
				->reorderableWithButtons()
				->reorderableWithDragAndDrop(false)
				->blocks([
					Builder\Block::make('speakers')
						->label('Speakers')
						->icon('heroicon-o-users')
						->maxItems(1),
					Builder\Block::make('sponsors')
						->label('Sponsors')
						->icon('heroicon-o-building-office-2')
						->maxItems(1),
					Builder\Block::make('partners')
						->label('Partners')
						->icon('heroicon-o-building-office')
						->maxItems(1),
					Builder\Block::make('latest-news')
						->label('Latest News')
						->icon('heroicon-o-newspaper')
						->maxItems(1),
					Builder\Block::make('layouts')
						->label('Custom Content')
						->icon('heroicon-m-bars-3-bottom-left')
						->schema([
							TextInput::make('name_content')
								->label('Title')
								->required(),
							TinyEditor::make('about')
								->label('Content')
								->profile('advanced')
								->required(),
						]),

				]),

			Repeater::make('banner_buttons')
				->schema([
					TextInput::make('text')->required(),
					TextInput::make('url')
						->required()
						->url(),
					ColorPicker::make('text_color'),
					ColorPicker::make('background_color'),
				])
				->columns(2),
		];
	}

	public function onActivate(): void
	{
		Hook::add('Frontend::Views::Head', function ($hookName, &$output) {
			$output .= '<script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>';
			$output .= '<link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />';
			$css = $this->url('everest.css');
			$output .= "<link rel='stylesheet' type='text/css' href='$css'/> ";

			if ($appearanceColor = $this->getSetting('appearance_color')) {
				$oklch = ColorFactory::new($appearanceColor)->to(ColorSpace::OkLch);
				$css = new CSSGenerator();
				$css->root_variable('p', "{$oklch->lightness}% {$oklch->chroma} {$oklch->hue}");

				$oklch = ColorFactory::new('#1F2937')->to(ColorSpace::OkLch);
				$css->root_variable('bc', "{$oklch->lightness}% {$oklch->chroma} {$oklch->hue}");

				$output .= <<<HTML
					<style>
						{$css->get_output()}
					</style>
				HTML;
			}
		});
	}

	public function getFormData(): array
	{
		return [
			'images' => $this->getSetting('images'),
			'appearance_color' => $this->getSetting('appearance_color'),
			'layouts' => $this->getSetting('layouts') ?? [] ,
			'name_content' => $this->getSetting('name_content'),
			'about' => $this->getSetting('about'),
			'top_navigation' => $this->getSetting('top_navigation'),
			'banner_buttons' => $this->getSetting('banner_buttons'),
		];
	}
}
