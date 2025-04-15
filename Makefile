html:
	LANG=C scripts/_generate_html

server:
	(cd www && php -S localhost:8000)

clean:
	rm -f scripts/BeautifulSoup.pyc
	rm -f text/*.log
	rm -f text/lpn-html.{4ct,4tc,css,idv,idx,lg,log,tmp,xref}
	rm -f text/lpn-html*.html
	rm -rf text/*.aux
	rm -rf text/*.dvi

distclean:	clean
	rm -rf www/html
	rm -f text/chap*-*.ps
