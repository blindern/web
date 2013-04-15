<?php

bs_side::set_title("Brun Sprit");

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();
$foreninger->set_active("brunsprit");

echo '
<h1>Brun Sprit</h1>

<p>Som navnet tilsier handler denne foreningen om brun sprit, og da spesielt Cognac.
Foreningen er for herrer på bruket som er glad i noe brunt i glasset sammen med god
mat og samtale. Det livslange medlemskapet gjelder for alle Brun Sprits medlemmer,
men det er til enhver tid 12 beboere som utgjør foreningen her på Blindern Studenterhjem.</p>

<p>De sagnomsuste Brun Sprit-møtene har gjort foreningen til et mystisk kapittel
i brukets historie og det er kun medlemmene som vet hva som foregår på
disse mye omtalte møtene. Brun Sprit har opptak med jevne mellomrom og alle
brukets herrer står fritt til å sende inn søknad om å få være med.</p>';

$foreninger->gen_page();