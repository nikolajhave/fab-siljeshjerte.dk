<div>

{foreach $links as $link}
    <ul><a href="/preview/{$link.id}" target="preview">{$link.name} ({$link.type})</a></ul>
{/foreach}

</div>
