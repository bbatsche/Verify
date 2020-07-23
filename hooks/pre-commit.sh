#!/bin/bash

git diff --cached --name-only | while read FILE; do
    if [[ "$FILE" =~ ^.+php$ ]]; then
        # Courtesy of swytsh
        if [[ -f $FILE ]]; then
            php -l "$FILE" 2> /dev/null
            if [ $? -ne 0 ]; then
                echo -e "\033[1;31m\tAborting Commit! There are syntax errors.\033[0m" >&2
                exit 1
            fi

            if ! [[ "$FILE" =~ src/function.php$ ]]; then
                composer style:check "$FILE" 2> /dev/null
                if [ $? -ne 0 ]; then
                    echo -e "\033[1;31m\tAborting Commit! Files do not follow coding standards.\033[0m" >&2
                    exit 1
                fi
            fi
        fi
    fi
done || exit $?

if [ $? -eq 0 ]; then
    composer test:static 2> /dev/null
    if [ $? -ne 0 ]; then
        echo -e "\033[1;31m\tAborting Commit! Static analyzer failed.\033[0m" >&2
        exit 1
    fi
fi

if [ $? -eq 0 ]; then
    composer test:unit 2> /dev/null
    if [ $? -ne 0 ]; then
        echo -e "\033[1;31m\tAborting Commit! There are broken unit tests.\033[0m" >&2
        exit 1
    fi
fi
