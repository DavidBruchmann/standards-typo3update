standards-typo3update
=====================

This Repository is a sub-repository of https://github.com/DavidBruchmann/automated-typo3-update/
which was forked from https://github.com/DanielSiepmann/automated-typo3-update.
The original repository never had a subrepository.

This sub-repository has to be loaded in the right directory of automated-typo3-update:
```
git clone https://github.com/DavidBruchmann/automated-typo3-update
git submodule add https://github.com/DavidBruchmann/standards-typo3update src/Standards/Typo3Update
Any package-files like composer.json are NOT up-to-date!
```

Branch alt-sorting
------------------
The Branch alt-sorting sorts any files like classes and configuration-files
in a different structure.
Main-purpose of the new structure is to create a further sub-repository only for TypoScript.
Currently classes in this branch are expected NOT to work as dependencies won't be loaded correctly.
