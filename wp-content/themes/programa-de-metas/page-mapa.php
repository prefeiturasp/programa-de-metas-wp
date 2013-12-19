<?php
/*
Template Name: Mapa
*/
?>
<?php get_header(); ?>
<div id="all" class="interna">
	<div class="nav">
		<div class="content">
			<ul>
				<li><a href="<?php echo bloginfo('url');?>/conheca-o-programa/" class="first">Conheça o programa</a>|</li>
				<li><a href="<?php echo bloginfo('url');?>/objetivos-e-metas/">Objetivos e metas</a>|</li>
				<li><a href="<?php echo bloginfo('url');?>/conceito-territorial/">Conceito territorial</a>|</li>
				<li><a href="http://planejasampa.prefeitura.sp.gov.br/index.php/contato/">Contato</a></li>
			</ul>
			
			<div class="social">
				<div class="fb">
				    <div class="fb-share-button" data-href="http://programademetas.info" data-type="button" data-width="120"></div>
				</div>
				
				<div class="tw">
				    <a href="https://twitter.com/share?url=<?php echo bloginfo('url');?>&text=Programa%20de%20Metas%20da%20Cidade%202013%20-2016%3A%20um%20convite%20ao%20planejamento%20urbano%20participativo." class="twitter-share-button" data-lang="pt">Tweet</a>
				    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				</div>
				
				<div class="gp">
				    <g:plus action="share" annotation="none"></g:plus>
				</div>
			</div>
		</div>
	</div>
    
    <div class="content mapa">
        <h1 class="logo">
            <a href="http://programademetas.info"><img src="<?php echo get_template_directory_uri(); ?>/img/logo-programa-de-metas.png"><a/>
        </h1>
        
        <p class="intro">
            Reduzir as desigualdades em uma cidade do tamanho e da complexidade de São Paulo não é tarefa fácil. O Programa de Metas 2013-2016 reconhece os limites de seu horizonte temporal para fazer frente a uma história de ações desordenadas e concentradoras sobre o território paulistano. Ao mesmo tempo, propõe-se a dar os primeiros passos no caminho da construção de um processo de planejamento participativo e transparente que aponte os eixos de superaçãodas desigualdades sociais, econômicas e regionais.
        </p>
        <a href="<?php echo bloginfo('url');?>/conheca-o-programa/" class="leia-mais">Saiba mais >></a>
            
        <div id="mapaSub">
            <div class="mapeamento">
                <img src="<?php echo get_template_directory_uri(); ?>/img/transp.png" alt="mapa" width="543" height="761" usemap="#Map" />
                <map name="Map" class="map">
                  <area shape="poly" coords="106,139,81,136,60,93,60,62,102,65,126,46,157,61,174,81,125,91" href="#" id="perus">
                  <area shape="poly" coords="124,168,150,184,178,181,174,157,170,132,176,106,176,86,139,93,127,95,109,133" href="#" id="pirituba">
                  <area shape="poly" coords="196,181,184,185,176,149,174,118,181,102,192,91,204,86,215,99,212,141" href="#" id="freguesia-do-o-brasilandia">
                  <area shape="poly" coords="234,192" href="#">
                  <area shape="poly" coords="236,190,202,185,219,79,226,91,229,93" href="#" id="casa-verde">
                  <area shape="poly" coords="264,194,241,194,238,150,235,109,239,97,253,107,258,130,304,145,284,156" href="#" id="santana">
                  <area shape="poly" coords="349,14,317,35,286,54,270,82,253,96,280,134,313,146,325,153,323,84" href="#" id="tremembe">
                  <area shape="poly" coords="332,196,305,204,274,200,270,187,279,166,300,151,318,151,326,160" href="#" id="vila-maria-guilherme">
                  <area shape="poly" coords="409,230,371,229,344,212,337,183,351,159,380,144,394,176,367,187,413,199" href="#" id="penha">
                  <area shape="poly" coords="416,196,376,187,397,176,385,147,409,147,419,151,413,180" href="#" id="ermelino">
                  <area shape="poly" coords="461,197,448,198,445,185,421,193,420,169,422,154,455,145,477,141,516,142,504,156,460,162" href="#" id="sao-miguel">
                  <area shape="poly" coords="527,179,514,152,492,163,462,164,464,191,486,203" href="#" id="itaim-paulista">
                  <area shape="poly" coords="508,247,490,244,474,238,466,238,468,220,462,203,465,194,489,205,503,197" href="#" id="guaianases">
                  <area shape="poly" coords="497,296,475,271,475,254,470,243,508,250,512,263,505,281" href="#" id="tiradentes">
                  <area shape="poly" coords="469,272,438,275,417,270,392,258,378,235,411,230,417,200,442,191,457,206,467,247" href="#" id="itaquera">
                  <area shape="poly" coords="496,302,457,325,421,324,405,300,390,276,389,268,389,258,436,280,471,274" href="#" id="mateus">
                  <area shape="poly" coords="406,309,384,273,358,266,358,276,366,291,385,309" href="#" id="sapopemba">
                  <area shape="poly" coords="386,270,359,264,334,253,322,233,336,231,333,215,342,210,376,237" href="#" id="aricanduva">
                  <area shape="poly" coords="366,295,356,268,332,258,309,256,295,264,310,286" href="#" id="vila-prudente">
                  <area shape="poly" coords="330,261,306,255,295,263,277,233,264,232,261,196,280,197,311,203,328,200,334,231,319,229" href="#" id="mooca">
                  <area shape="poly" coords="277,236,270,255,257,258,231,242,213,229,225,214,233,193,257,194,259,226" href="#" id="se">
                  <area shape="poly" coords="231,191,212,228,183,220,168,214,155,224,136,236,124,213,135,197,125,171,161,186,185,183" href="#" id="lapa">
                  <area shape="poly" coords="128,235,105,253,79,269,78,298,108,288,126,281,136,291,138,302,169,298,185,305,193,274,178,242,153,232" href="#" id="butanta">
                  <area shape="poly" coords="216,264,201,314,191,308,196,278,187,252,177,237,156,227,170,217,190,226,210,233,234,247" href="#" id="pinheiros">
                  <area shape="poly" coords="256,317,242,318,231,307,215,294,220,266,237,253,271,262" href="#" id="vila-mariana">
                  <area shape="poly" coords="260,360,261,338,263,314,274,266,279,242,307,289,308,316,297,336" href="#" id="ipiranga">
                  <area shape="poly" coords="258,364,261,335,257,318,240,321,228,331,224,324,218,334,230,349" href="#" id="jabaquara">
                  <area shape="poly" coords="236,423,273,407,256,390,257,369,226,352,217,337,210,347,221,380,207,392" href="#" id="cidade-ademar">
                  <area shape="poly" coords="202,390,216,378,209,352,215,331,233,323,224,304,212,302,202,313,186,311,172,314,164,329,163,339" href="#" id="santo-amaro">
                  <area shape="poly" coords="159,333,180,306,169,303,149,303,137,303,130,300,115,316,103,329,92,354,87,387,107,373,128,355,139,330" href="#" id="campo-limpo">
                  <area shape="poly" coords="167,348,166,401,155,439,173,471,186,511,200,557,228,557,255,544,266,518,263,481,230,420" href="#" id="socorro">
                  <area shape="poly" coords="90,398,90,421,120,455,124,439,150,439,160,415,165,393,164,366,164,349,158,335,142,331" href="#" id="m-boi-mirim">
                  <area shape="poly" coords="122,729,159,718,213,708,248,719,258,700,286,670,279,620,276,573,254,551,205,562,180,503,156,445,129,447,114,460,87,503,116,535,110,584,68,623,105,676" href="#" id="parelheiros">
                </map>
            </div>
            <div class="subs">
                <div class="perus">perus</div>
                <div class="pirituba">pirituba</div>
                <div class="freguesia">freguesia brasilandia</div>
                <div class="casa">casa verde</div>
                <div class="santana">santana tucuruvi</div>
                <div class="tremembe">tremembe jaçanã</div>
                <div class="maria">vila maria vila guilherme</div>
                <div class="penha">penha</div>
                <div class="ermelino">ermelino matarazzo</div>
                <div class="miguel">são miguel</div>
                <div class="itaim">itaim paulista</div>
                <div class="lapa">lapa</div>
                <div class="se">sé</div>
                <div class="mooca">mooca</div>
                <div class="aricanduva">aricanduva</div>
                <div class="itaquera">itaquera</div>
                <div class="guaianazes">guaianases</div>
                <div class="butanta">butantã</div>
                <div class="pinheiros">pinheiros</div>
                <div class="mariana">vila mariana</div>
                <div class="ipiranga">ipiranga</div>
                <div class="prudente">vila prudente</div>
                <div class="sapopemba">sapopemba</div>
                <div class="tiradentes">cidade tiradentes</div>
                <div class="mateus">são mateus</div>
                <div class="campo">campo limpo</div>
                <div class="santo">santo amaro</div>
                <div class="jabaquara">jabaquara</div>
                <div class="mirim">m'boi mirim</div>
                <div class="socorro">socorro</div>
                <div class="ademar">cidade ademar</div>
                <div class="parelheiros">parelheiros</div>
            </div>
        </div>
        <div class="colunaRegioes">
            <h2>Desça a página para ver as metas relacionadas ou selecione mais regiões.</h2>
            <p class="selecionadas">REGIÕES SELECIONADAS</p>
            <a href="#" title="LIMPAR" class="limpar">LIMPAR</a>
            <p id="legenda"></p>
        </div>
    </div>
    
    <div class="metas">
    </div>
</div>