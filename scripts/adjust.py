import re
import sys

from bs4 import BeautifulSoup


#perl -0777 -ne 'print $1 if /<body\s*>(.*?)<\/body>/s' ${HTML} > temp.html

# cat temp.html \
# | tr -s " " \
## | sed 's/href="/href="lpnpage.php?pagetype=html\&pageid=/g' \
## | sed 's/\.html//g' \
## | sed 's/src="/src="html\//g' \
# | sed 's/class="fancyvrb"/class="source swish"/g' \
## | sed 's/Exercise/<strong>Exercise<\/strong>/g' \

def _remove_smart_quotes (text):
    return text.replace(u"\u2018", '') \
                .replace(u"\u2019", '') \
                .replace(u"\u201c", '') \
                .replace(u"\u201d", '')


def pretreat(soup):
    """Get rid of all the cruft"""

    crufts = [
        'cmtt-10',
        'cmbx-10',
        'cmti-10',
    ]

    for span in soup.find_all('span', class_=crufts):
        span.unwrap()
    # for par in soup.find_all('p', class_='noindent'):
    #     par.unwrap()


def intercept_links(soup):
    """Pass all internal links though lpnpage.php"""
    links = soup.find_all('a', href=lambda x: x and x.startswith('lpn-html'))
    for link in links:
        link['href'] = 'lpnpage.php?pagetype=html&pageid=' + link['href'].replace('.html', '')


def fix_exercise(soup):
    """Oddly specific, but here we are"""

    exes = soup.find_all('span', class_='head')
    for span in exes:
        contents = list(span.contents)
        span.clear()
        new_strong = soup.new_tag('strong')
        for content in contents:
            new_strong.append(content)
        span.append(new_strong)

    theorems = soup.select('div.newtheorem:has(strong:-soup-contains("Exercise"))')

    for theorem in theorems:
        theorem['class'].append('swish')
        theorem['class'].append('exercise')


def fix_images(soup):
    """Images are somewhere else, for some reason"""
    imgs = soup.find_all('img')
    for img in imgs:
        img['src'] = 'html/' + img['src']


def classify_snippets(soup):

    pres = soup.find_all('pre', class_='fancyvrb')

    for pre in pres:

        # query
        # TODO: multiline ones like S5.1
        if pre.text.lstrip().startswith('?-'):
            pre['class'] = ['query']
            contents = list(pre.contents)
            pre.clear()
            new_span = soup.new_tag('span', attrs={"class": "swish query",})
            for content in contents:
                new_span.append(content)
            pre.append(new_span)

        # sometimes the authors didn't add the ?-
        elif len(pre.text.split("\n")) == 1 and maybe_prolog(pre.text):
            pre['class'] = ['swish', 'query', 'guessed']

        # looks like source
        elif maybe_prolog(pre.text):
            pre['class'] = ['source', 'swish']

        # text output ie. verbatim
        else:
            pre['class'] = ['verbatim']


def fix_query_list(soup: BeautifulSoup):
    for ol in soup.find_all('ol', class_='enumerate1'):
        if maybe_prolog(ol.text):
            ol['class'].append('swish')
            ol['class'].append('query-list')

    for elem in soup.select('li.enumerate'):
        newtext = _remove_smart_quotes(elem.text)
        # contents = list(elem.contents)
        elem.clear()

        newspan = soup.new_tag('span') #, attrs={'class':'verb'})
        newspan.string = newtext
        # elem.unwrap()
        # new_span = soup.new_tag('span')
        # for content in contents:
        #     new_span.append(content)
        elem.append(newspan)

        #print(elem)


def maybe_prolog(content:str) -> bool:
    #print(content)
    if re.match('[a-z_][a-zA-Z0-9_]*\([a-zA-Z0-9_\[\], ]*\)', content):
        return True
    if '--' in content:
        return True
    return False


## main -----------------------------------------------------------------------


if __name__ == '__main__':

    infile = sys.argv[1]

    # print(infile)
    enc = 'iso-8859-15'

    with open(infile, 'r', encoding=enc) as fh:
        contents = fh.read()

    soup = BeautifulSoup(contents, 'html.parser')

    pretreat(soup)
    fix_exercise(soup)
    intercept_links(soup)
    fix_images(soup)
    classify_snippets(soup)
    fix_query_list(soup)

    doc = soup.body.decode_contents()

    # print(doc.prettify())
    print(doc)