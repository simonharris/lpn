from html import escape
import unittest

from scripts.adjust import maybe_prolog


class MyTestCase(unittest.TestCase):

    def test_is_prolog(self):
        """Mostly genuine examples from the book"""

        snips = {
            "The quick brown fox": False,
            # 4.1
            "We can specify lists in Prolog by enclosing the elements of the list in square \
            brackets (that is, the symbols [ and ]). The elements are separated \
            by commas. For example, the first list shown above, [mia, vincent, jules, \
            yolanda], is a list with four elements, namely mia, vincent, jules, \
            and yolanda. The length of a list is the number of elements" : False,
            # 5.1
             "add_3_and_double(X,Y) :- Y is (X+3)*2.": True,
            # 5.3
            "len([],0).\nlen([_|T],N) :- len(T,X), N is X+1.": True,
            # 8.1
            escape("s --> np,vp. \n\nnp --> det,n. \n\nvp --> v,np. \nvp --> v. "): True,
        }

        for snip, is_good in snips.items():
            self.assertEqual(maybe_prolog(snip), is_good)

