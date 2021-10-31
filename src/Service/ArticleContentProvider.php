<?php

declare(strict_types=1);

namespace App\Service;

use App\Homework\ArticleContentProviderInterface;

class ArticleContentProvider implements ArticleContentProviderInterface
{
    protected bool $boldWords = false;
    protected PasteWordsService $pasteWordsService;

    protected array $contents = [
        '- Lorem **ipsum** dolor sit amet, ~~consectetur~~ adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Purus sit amet luctus venenatis lectus magna fringilla urna porttitor. Sit amet cursus sit amet. Mattis molestie a iaculis at erat. Quis auctor elit sed vulputate mi. Vulputate dignissim suspendisse in est ante in nibh. Sed augue lacus viverra vitae. At in tellus integer feugiat scelerisque varius morbi. Tortor at risus viverra adipiscing at in. Rhoncus urna neque viverra justo nec ultrices.',
        '- Vitae et leo ~~duis~~ ut diam quam **nulla** porttitor massa. Justo nec ultrices dui sapien eget mi proin. Lacus vel facilisis volutpat est velit egestas dui id ornare. Nec feugiat nisl pretium fusce id velit. Sem et tortor consequat id porta nibh venenatis. Ultricies lacus sed turpis tincidunt id aliquet risus feugiat in. Tincidunt nunc pulvinar sapien et ligula. Diam sit amet nisl suscipit adipiscing bibendum est. Auctor elit sed vulputate mi sit amet mauris. Tincidunt praesent semper feugiat nibh sed. Pulvinar proin gravida hendrerit lectus a. Pharetra magna ac placerat vestibulum lectus mauris ultrices eros. Nascetur ridiculus mus mauris vitae ultricies leo integer. Lacus vestibulum sed arcu non. Metus vulputate eu scelerisque felis imperdiet proin fermentum. Tincidunt nunc pulvinar sapien et ligula ullamcorper malesuada proin. Praesent semper feugiat nibh sed pulvinar proin gravida. Mauris ultrices eros in cursus turpis massa. Donec pretium vulputate sapien nec sagittis aliquam malesuada.',
        '- Et **magnis** dis parturient ~~montes~~ nascetur ridiculus mus. Facilisi etiam dignissim diam quis enim lobortis scelerisque fermentum. In metus vulputate eu scelerisque felis. Purus sit amet luctus venenatis lectus magna. Egestas diam in arcu cursus euismod quis viverra nibh. Sodales ut etiam sit amet nisl purus in mollis. Tortor pretium viverra suspendisse potenti nullam ac tortor. Sit amet luctus venenatis lectus magna. Orci porta non pulvinar neque. Tincidunt vitae semper quis lectus nulla. Ac orci phasellus egestas tellus rutrum tellus pellentesque eu tincidunt. Egestas integer eget aliquet nibh praesent tristique magna sit. Arcu non sodales neque sodales ut etiam sit amet nisl. Rhoncus est pellentesque elit ullamcorper dignissim. Turpis massa tincidunt dui ut ornare lectus sit amet est.',
        '- Gravida in ~~fermentum~~ et **sollicitudin** ac orci. Elit duis tristique sollicitudin nibh sit amet commodo nulla facilisi. Nulla facilisi etiam dignissim diam. Diam quam nulla porttitor massa id neque aliquam vestibulum morbi. Convallis a cras semper auctor. Nibh venenatis cras sed felis eget. Interdum consectetur libero id faucibus nisl tincidunt eget nullam non. Iaculis eu non diam phasellus vestibulum lorem sed. In ornare quam viverra orci. Lacus sed viverra tellus in hac habitasse platea. Egestas dui id ornare arcu odio ut. Aliquam etiam erat velit scelerisque in dictum. Integer eget aliquet nibh praesent tristique magna sit amet purus.',
        '- **Pellentesque** habitant morbi ~~tristique~~ senectus. Ut sem viverra aliquet eget sit amet tellus. Aliquam sem fringilla ut morbi tincidunt. Nunc sed augue lacus viverra vitae congue eu. Proin sed libero enim sed faucibus turpis in eu. Proin fermentum leo vel orci. Ut sem nulla pharetra diam sit amet nisl. Magna eget est lorem ipsum dolor sit. Lacus vestibulum sed arcu non odio euismod lacinia at. Sagittis aliquam malesuada bibendum arcu. Vitae elementum curabitur vitae nunc sed velit dignissim. Commodo quis imperdiet massa tincidunt. Fermentum et sollicitudin ac orci phasellus egestas tellus rutrum tellus. Fusce id velit ut tortor pretium viverra suspendisse.',
        '- Duis at ~~tellus~~ at urna. **Commodo** quis imperdiet massa tincidunt nunc. Pellentesque massa placerat duis ultricies. Est sit amet facilisis magna etiam. Bibendum est ultricies integer quis auctor elit sed vulputate mi. Tincidunt nunc pulvinar sapien et. Mauris vitae ultricies leo integer malesuada. Venenatis tellus in metus vulputate eu. Morbi enim nunc faucibus a pellentesque sit amet porttitor eget. Sagittis nisl rhoncus mattis rhoncus urna neque viverra. Ornare quam viverra orci sagittis eu volutpat odio facilisis.',
        '- **Ultrices** sagittis orci a ~~scelerisque~~ purus semper eget. Ut morbi tincidunt augue interdum velit euismod in. Enim ut tellus elementum sagittis vitae. Nunc aliquet bibendum enim facilisis gravida neque convallis a. Magna eget est lorem ipsum dolor. Aliquet nibh praesent tristique magna sit amet purus gravida quis. Dui vivamus arcu felis bibendum ut tristique et egestas. Id diam maecenas ultricies mi eget. Nulla aliquet enim tortor at auctor. Leo urna molestie at elementum eu facilisis sed odio morbi.',
        '- Neque convallis a cras ~~semper~~ auctor **neque**. Ultrices tincidunt arcu non sodales neque sodales. Cras ornare arcu dui vivamus arcu felis. Ullamcorper a lacus vestibulum sed arcu non odio euismod lacinia. Luctus accumsan tortor posuere ac ut consequat semper viverra nam. Vitae nunc sed velit dignissim. Egestas egestas fringilla phasellus faucibus scelerisque. Metus dictum at tempor commodo ullamcorper a lacus vestibulum. Purus viverra accumsan in nisl nisi scelerisque eu ultrices. Pellentesque habitant morbi tristique senectus et netus.',
        '- Ac **tortor** vitae purus ~~faucibus~~ ornare suspendisse sed nisi. Odio pellentesque diam volutpat commodo sed egestas egestas fringilla. Enim nulla aliquet porttitor lacus luctus accumsan tortor. Egestas congue quisque egestas diam in arcu cursus euismod. Turpis egestas maecenas pharetra convallis posuere morbi leo. Donec et odio pellentesque diam volutpat commodo sed. Ultrices mi tempus imperdiet nulla malesuada pellentesque elit eget. Turpis massa sed elementum tempus egestas. Mus mauris vitae ultricies leo. Viverra accumsan in nisl nisi scelerisque. Cras tincidunt lobortis feugiat vivamus at augue eget arcu dictum. Pellentesque massa placerat duis ultricies. Ipsum nunc aliquet bibendum enim facilisis gravida neque convallis. Porttitor massa id neque aliquam. Tincidunt eget nullam non nisi est sit amet. At lectus urna duis convallis. Turpis in eu mi bibendum. Massa sed elementum tempus egestas sed. Ut placerat orci nulla pellentesque dignissim enim sit. Ut tortor pretium viverra suspendisse potenti nullam ac tortor vitae.',
        '- Turpis massa ~~tincidunt~~ dui ut **ornare** lectus. Nisi est sit amet facilisis magna etiam tempor. Sed egestas egestas fringilla phasellus faucibus scelerisque eleifend donec. Aliquam purus sit amet luctus venenatis. Dignissim diam quis enim lobortis scelerisque fermentum dui. Aliquet nibh praesent tristique magna sit amet purus gravida quis. Mauris augue neque gravida in fermentum et sollicitudin. Arcu odio ut sem nulla pharetra diam sit amet nisl. Leo in vitae turpis massa sed elementum tempus. Leo in vitae turpis massa sed. Lectus vestibulum mattis ullamcorper velit. Aliquam nulla facilisi cras fermentum odio eu feugiat. Molestie a iaculis at erat pellentesque adipiscing commodo.',
    ];

    public function __construct(bool $boldWords, PasteWordsService $pasteWordsService)
    {
        $this->boldWords = $boldWords;
        $this->pasteWordsService = $pasteWordsService;
    }

    public function get(int $paragraphs, string $word = null, int $wordsCount = 0): string
    {
        if ($paragraphs <= 0) {
            return '';
        }

        $content = $this->createContent($paragraphs);

        if (null !== $word && $wordsCount > 0) {
            $word = $this->boldWords ? "**$word**" : "_{$word}_";

            $content = $this->pasteWordsService->paste($content, $word, $wordsCount);
        }

        return $content;
    }

    private function createContent(int $paragraphs): string
    {
        $last = count($this->contents) - 1;

        $content = '';
        do {
            $content .= $this->contents[random_int(0, $last)];
            $content .= "\n";
        } while (--$paragraphs);

        return $content;
    }
}
