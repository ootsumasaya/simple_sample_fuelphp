FROM php:5.6-alpine

# composerの公式イメージからcomposerの実行ファイルだけ組み込む
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer