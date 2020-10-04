{extends file="parent:frontend/detail/content/buy_container.tpl"}

{block name='frontend_detail_index_buy_container_base_info'}
    {$smarty.block.parent}
    <ul class="product--base-info list--unstyled">
        {if $sArticle.Sten.color }
            <li class="base-info--entry entry--sku">
                <strong class="entry--label">
                    Color
                </strong>
                <span class="entry--content"
                      itemprop="color">
        {$sArticle.Sten.color}
    </span>
            </li>
        {/if}
        {if $sArticle.Sten.weight }
            <li class="base-info--entry entry--sku">
                <strong class="entry--label">
                    Weight
                </strong>
                <span class="entry--content"
                      itemprop="color">
        {$sArticle.Sten.weight} g
    </span>
            </li>
        {/if}
    </ul>
{/block}
