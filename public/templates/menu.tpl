<div>

{foreach $links as $link}
<ul><a href="/preview/{$link.id}" target="preview">{$link.name} ({$link.type}/{$link.id})</a></ul>
{/foreach}

</div>
