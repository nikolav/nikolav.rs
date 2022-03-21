<?php

if (
    !isset($_POST)
    && !isset($_POST['validation'])
    && ($_POST['vaidation'] != 'guestbook_utisci')
) {
    header('Location: /');
    exit;
} else {

    $resp = '';

    switch ($_POST['action']) {

        case 'utisci_read':

            $gbook      = new SimpleXMLElement('./guestbookutisci.xml', LIBXML_NOBLANKS, true);
            $xKomentari = $gbook->comment;

            foreach ($xKomentari as $k => $v) {
                $resp .= '<p class="utisci_komentar">';
                $resp .= '<span class="komentar_meta">';
                $resp .= '<span class="utisci_user"><strong>' . htmlspecialchars($v['user']) . '</strong></span><br/>';
                if ((string) $v['kontakt']) {
                    $resp .= '<span class="utisci_kontakt"><a href="mailto:' . htmlspecialchars($v['kontakt']) . '">' . htmlspecialchars($v['kontakt']) . '</a></span><br/>';
                }
                $resp .= '<span class="utisci_date"><small><em>' . htmlspecialchars($v['date']) . '</em></small></span>';
                $resp .= '</span><br/><br/>';
                $resp .= '<span class="komentar_sadrzaj">';
                $resp .= strip_tags(nl2br((string) $v), '<br>');
                $resp .= '</span><br/><br/><br/></p>';
            }

            break;

        case 'utisci_write':
            $gbook        = new SimpleXMLElement('./guestbookutisci.xml', LIBXML_NOBLANKS, true);
            $c            = $gbook->addChild("comment", htmlspecialchars($_POST['komentar']));
            $c['date']    = date('j/n/Y');
            $c['user']    = htmlspecialchars($_POST['user']);
            $c['kontakt'] = htmlspecialchars($_POST['email']);

            $doc = dom_import_simplexml($gbook);
            $doc->ownerDocument->formatOutput = true;
            $bytes = $doc->ownerDocument->save('./guestbookutisci.xml');

            $resp = new stdClass;
            if ($bytes) {
                $resp->entry_ok             = "1";
                $resp->komentar             = new stdClass;
                $resp->komentar->date       = htmlspecialchars((string) $c['date']);
                $resp->komentar->user       = htmlspecialchars((string) $c['user']);
                $resp->komentar->kontakt    = htmlspecialchars((string) $c['kontakt']);
                $resp->komentar->sadrzaj    = strip_tags(nl2br((string) $c), '<br>');
            } else {
                $resp->entry_ok = "0";
            }

            header("Content-Type: application/json");
            $resp = json_encode($resp);
            break;

        default:

            break;
    }
}

echo $resp;
exit;
