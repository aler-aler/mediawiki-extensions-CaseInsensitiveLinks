# CaseInsensitiveLinks
An extension for MediaWiki wikis with wgCapitalLinks disabled that solves the `[[Pagename|pagename]]` problem.
If there are pages `Xxx`, `xxx`, `Yyy` and `zzz`, then `[[yyy]]` will redirect to `Yyy`, `[[Zzz]]` to `zzz`; `[[Xxx]]` and `[[xxx]]` will both work normally. It only checks the first character and makes no direct DB calls but idk anymore if that's the efficient approach.

Made for MediaWiki 1.37 but should work on other versions.
