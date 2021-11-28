<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Article\Article;

class ArticleProvider
{
    public function getArticle(): Article
    {
        return $this->getArticles()[mt_rand(0, 4)];
    }

    /**
     * @return Article[]
     */
    public function getArticles(): array
    {
        return [
            Article::create(
                'new-article-1',
                'Некая статья 1',
                '/images/cat-food.jpg',
                <<<TEXT
Lorem ipsum dolor sit amet, **consectetur** adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Odio pellentesque diam volutpat commodo sed. Adipiscing tristique risus nec feugiat in fermentum posuere urna nec. Dignissim sodales ut eu sem. Commodo elit at imperdiet dui accumsan sit amet nulla. Purus in massa tempor nec. Facilisis volutpat est velit egestas dui id. Nullam ac tortor vitae purus faucibus ornare suspendisse sed. Dictum non consectetur a erat nam at lectus urna. Quam adipiscing vitae proin sagittis nisl. Pharetra convallis posuere morbi leo urna molestie at elementum. Interdum posuere lorem ipsum dolor sit amet consectetur. Odio tempor orci dapibus ultrices. Libero justo laoreet sit amet cursus sit amet dictum sit. Massa tincidunt nunc pulvinar sapien. Purus non enim praesent elementum facilisis leo vel fringilla est. Neque egestas congue quisque egestas diam in arcu. Commodo ullamcorper a lacus vestibulum sed arcu non.

Vestibulum rhoncus est pellentesque elit. Tempus imperdiet nulla malesuada pellentesque elit eget gravida cum sociis. Dignissim sodales ut eu sem integer vitae justo. Vulputate ut pharetra sit amet aliquam id. Vitae nunc sed velit dignissim sodales ut eu. Nisi porta lorem mollis aliquam ut porttitor. Hendrerit dolor magna eget est lorem ipsum dolor sit amet. Nibh nisl condimentum id venenatis a condimentum vitae sapien. Mauris a diam maecenas sed enim ut sem viverra aliquet. Ullamcorper dignissim cras tincidunt lobortis feugiat vivamus. Tristique senectus et netus et. Sit amet volutpat consequat mauris nunc congue. Pellentesque massa placerat duis ultricies lacus sed turpis tincidunt. Dui vivamus arcu felis bibendum ut tristique.

Diam sollicitudin tempor id eu nisl. Ornare massa eget egestas purus viverra. Imperdiet proin fermentum leo vel orci. Volutpat ac tincidunt vitae semper quis. Dui vivamus arcu felis bibendum ut tristique et. Massa tempor nec feugiat nisl pretium fusce id velit. Purus faucibus ornare suspendisse sed nisi lacus sed viverra tellus. Amet facilisis magna etiam tempor orci eu. Proin libero nunc consequat interdum varius sit amet mattis. Tempor id eu nisl nunc. Lacus suspendisse faucibus interdum posuere lorem ipsum dolor sit. Ipsum dolor sit amet consectetur adipiscing. Nisi scelerisque eu ultrices vitae. Lorem dolor sed viverra ipsum nunc aliquet bibendum enim facilisis. Risus viverra adipiscing at in tellus integer. Egestas egestas fringilla phasellus faucibus scelerisque eleifend donec pretium vulputate. Habitant morbi tristique senectus et netus et malesuada fames. Integer eget aliquet nibh praesent tristique magna sit.
TEXT
            ),
            Article::create(
                'new-article-2',
                'Некая статья 2',
                '/images/cat-banner.jpg',
                <<<TEXT
Lorem ipsum dolor sit amet, consectetur **adipiscing** elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Odio pellentesque diam volutpat commodo sed. Adipiscing tristique risus nec feugiat in fermentum posuere urna nec. Dignissim sodales ut eu sem. Commodo elit at imperdiet dui accumsan sit amet nulla. Purus in massa tempor nec. Facilisis volutpat est velit egestas dui id. Nullam ac tortor vitae purus faucibus ornare suspendisse sed. Dictum non consectetur a erat nam at lectus urna. Quam adipiscing vitae proin sagittis nisl. Pharetra convallis posuere morbi leo urna molestie at elementum. Interdum posuere lorem ipsum dolor sit amet consectetur. Odio tempor orci dapibus ultrices. Libero justo laoreet sit amet cursus sit amet dictum sit. Massa tincidunt nunc pulvinar sapien. Purus non enim praesent elementum facilisis leo vel fringilla est. Neque egestas congue quisque egestas diam in arcu. Commodo ullamcorper a lacus vestibulum sed arcu non.

Vestibulum rhoncus est pellentesque elit. Tempus imperdiet nulla malesuada pellentesque elit eget gravida cum sociis. Dignissim sodales ut eu sem integer vitae justo. Vulputate ut pharetra sit amet aliquam id. Vitae nunc sed velit dignissim sodales ut eu. Nisi porta lorem mollis aliquam ut porttitor. Hendrerit dolor magna eget est lorem ipsum dolor sit amet. Nibh nisl condimentum id venenatis a condimentum vitae sapien. Mauris a diam maecenas sed enim ut sem viverra aliquet. Ullamcorper dignissim cras tincidunt lobortis feugiat vivamus. Tristique senectus et netus et. Sit amet volutpat consequat mauris nunc congue. Pellentesque massa placerat duis ultricies lacus sed turpis tincidunt. Dui vivamus arcu felis bibendum ut tristique.
TEXT
            ),
            Article::create(
                'new-article-3',
                'Некая статья 3',
                '/images/cat-banner1.jpg',
                <<<TEXT
Vestibulum **rhoncus** est pellentesque elit. Tempus imperdiet nulla malesuada pellentesque elit eget gravida cum sociis. Dignissim sodales ut eu sem integer vitae justo. Vulputate ut pharetra sit amet aliquam id. Vitae nunc sed velit dignissim sodales ut eu. Nisi porta lorem mollis aliquam ut porttitor. Hendrerit dolor magna eget est lorem ipsum dolor sit amet. Nibh nisl condimentum id venenatis a condimentum vitae sapien. Mauris a diam maecenas sed enim ut sem viverra aliquet. Ullamcorper dignissim cras tincidunt lobortis feugiat vivamus. Tristique senectus et netus et. Sit amet volutpat consequat mauris nunc congue. Pellentesque massa placerat duis ultricies lacus sed turpis tincidunt. Dui vivamus arcu felis bibendum ut tristique.

Diam sollicitudin tempor id eu nisl. Ornare massa eget egestas purus viverra. Imperdiet proin fermentum leo vel orci. Volutpat ac tincidunt vitae semper quis. Dui vivamus arcu felis bibendum ut tristique et. Massa tempor nec feugiat nisl pretium fusce id velit. Purus faucibus ornare suspendisse sed nisi lacus sed viverra tellus. Amet facilisis magna etiam tempor orci eu. Proin libero nunc consequat interdum varius sit amet mattis. Tempor id eu nisl nunc. Lacus suspendisse faucibus interdum posuere lorem ipsum dolor sit. Ipsum dolor sit amet consectetur adipiscing. Nisi scelerisque eu ultrices vitae. Lorem dolor sed viverra ipsum nunc aliquet bibendum enim facilisis. Risus viverra adipiscing at in tellus integer. Egestas egestas fringilla phasellus faucibus scelerisque eleifend donec pretium vulputate. Habitant morbi tristique senectus et netus et malesuada fames. Integer eget aliquet nibh praesent tristique magna sit.

Enim neque volutpat ac tincidunt vitae semper quis. Viverra vitae congue eu consequat. Ultricies lacus sed turpis tincidunt. Fermentum posuere urna nec tincidunt praesent semper feugiat nibh. Eget nulla facilisi etiam dignissim. Id venenatis a condimentum vitae sapien pellentesque. Amet est placerat in egestas erat imperdiet. Nisi porta lorem mollis aliquam ut porttitor leo a diam. A iaculis at erat pellentesque adipiscing commodo elit. Tellus in metus vulputate eu scelerisque felis imperdiet proin. Rhoncus urna neque viverra justo nec. Dui ut ornare lectus sit amet est placerat. Blandit libero volutpat sed cras ornare arcu. Laoreet suspendisse interdum consectetur libero id faucibus nisl tincidunt. Posuere lorem ipsum dolor sit amet. Quis enim lobortis scelerisque fermentum. Euismod in pellentesque massa placerat.

Pellentesque massa placerat duis ultricies lacus. Morbi blandit cursus risus at ultrices. Tristique et egestas quis ipsum suspendisse ultrices gravida. Posuere sollicitudin aliquam ultrices sagittis orci a scelerisque. Ipsum dolor sit amet consectetur adipiscing elit duis. Dolor sit amet consectetur adipiscing elit. Mauris in aliquam sem fringilla ut. Facilisis gravida neque convallis a cras. Et leo duis ut diam quam nulla porttitor. Ut ornare lectus sit amet est placerat. Leo vel orci porta non pulvinar neque laoreet suspendisse. Habitant morbi tristique senectus et netus et. Commodo sed egestas egestas fringilla. Vulputate eu scelerisque felis imperdiet. Id semper risus in hendrerit. Euismod elementum nisi quis eleifend quam adipiscing vitae. Lorem ipsum dolor sit amet consectetur. Dictum sit amet justo donec enim diam vulputate. Non blandit massa enim nec dui.
TEXT
            ),
            Article::create(
                'new-article-4',
                'Некая статья 4',
                '/images/cat-food.jpg',
                <<<TEXT
Diam sollicitudin **tempor** id eu nisl. Ornare massa eget egestas purus viverra. Imperdiet proin fermentum leo vel orci. Volutpat ac tincidunt vitae semper quis. Dui vivamus arcu felis bibendum ut tristique et. Massa tempor nec feugiat nisl pretium fusce id velit. Purus faucibus ornare suspendisse sed nisi lacus sed viverra tellus. Amet facilisis magna etiam tempor orci eu. Proin libero nunc consequat interdum varius sit amet mattis. Tempor id eu nisl nunc. Lacus suspendisse faucibus interdum posuere lorem ipsum dolor sit. Ipsum dolor sit amet consectetur adipiscing. Nisi scelerisque eu ultrices vitae. Lorem dolor sed viverra ipsum nunc aliquet bibendum enim facilisis. Risus viverra adipiscing at in tellus integer. Egestas egestas fringilla phasellus faucibus scelerisque eleifend donec pretium vulputate. Habitant morbi tristique senectus et netus et malesuada fames. Integer eget aliquet nibh praesent tristique magna sit.

Enim neque volutpat ac tincidunt vitae semper quis. Viverra vitae congue eu consequat. Ultricies lacus sed turpis tincidunt. Fermentum posuere urna nec tincidunt praesent semper feugiat nibh. Eget nulla facilisi etiam dignissim. Id venenatis a condimentum vitae sapien pellentesque. Amet est placerat in egestas erat imperdiet. Nisi porta lorem mollis aliquam ut porttitor leo a diam. A iaculis at erat pellentesque adipiscing commodo elit. Tellus in metus vulputate eu scelerisque felis imperdiet proin. Rhoncus urna neque viverra justo nec. Dui ut ornare lectus sit amet est placerat. Blandit libero volutpat sed cras ornare arcu. Laoreet suspendisse interdum consectetur libero id faucibus nisl tincidunt. Posuere lorem ipsum dolor sit amet. Quis enim lobortis scelerisque fermentum. Euismod in pellentesque massa placerat.

Pellentesque massa placerat duis ultricies lacus. Morbi blandit cursus risus at ultrices. Tristique et egestas quis ipsum suspendisse ultrices gravida. Posuere sollicitudin aliquam ultrices sagittis orci a scelerisque. Ipsum dolor sit amet consectetur adipiscing elit duis. Dolor sit amet consectetur adipiscing elit. Mauris in aliquam sem fringilla ut. Facilisis gravida neque convallis a cras. Et leo duis ut diam quam nulla porttitor. Ut ornare lectus sit amet est placerat. Leo vel orci porta non pulvinar neque laoreet suspendisse. Habitant morbi tristique senectus et netus et. Commodo sed egestas egestas fringilla. Vulputate eu scelerisque felis imperdiet. Id semper risus in hendrerit. Euismod elementum nisi quis eleifend quam adipiscing vitae. Lorem ipsum dolor sit amet consectetur. Dictum sit amet justo donec enim diam vulputate. Non blandit massa enim nec dui.
TEXT
            ),
            Article::create(
                'new-article-5',
                'Некая статья 5',
                '/images/cat-banner.jpg',
                <<<TEXT
Pellentesque massa placerat **duis** ultricies lacus. Morbi blandit cursus risus at ultrices. Tristique et egestas quis ipsum suspendisse ultrices gravida. Posuere sollicitudin aliquam ultrices sagittis orci a scelerisque. Ipsum dolor sit amet consectetur adipiscing elit duis. Dolor sit amet consectetur adipiscing elit. Mauris in aliquam sem fringilla ut. Facilisis gravida neque convallis a cras. Et leo duis ut diam quam nulla porttitor. Ut ornare lectus sit amet est placerat. Leo vel orci porta non pulvinar neque laoreet suspendisse. Habitant morbi tristique senectus et netus et. Commodo sed egestas egestas fringilla. Vulputate eu scelerisque felis imperdiet. Id semper risus in hendrerit. Euismod elementum nisi quis eleifend quam adipiscing vitae. Lorem ipsum dolor sit amet consectetur. Dictum sit amet justo donec enim diam vulputate. Non blandit massa enim nec dui.
TEXT
            ),
        ];
    }
}
