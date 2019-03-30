<h3>Orientações sobre a estrutura de banco de dados</h3>
<br> Sigua as 4 dicas abaixo e será mais feliz ! Essas orientações não são obrigatorias, seguindo o código gerado irá funcionar de forma mais facil. 
<a href="https://github.com/bjverde/formDin/wiki/Usando-DAO-e-VO#dicas-para-modelar-o-banco-de-dados" target="_blank">Veja na Wiki do formDin em detalhes cada dica.</a>
<ul>
	<li>NÃO use chaves primárias composta !! Evite chaves primarias compostas. Procure utilizar sempre a chaves primaria simples com AUTOINCREMENT. Transforme as chaves compostas em chaves candidatas com Unique Key.</li>
	<li>Procure criar chaves primárias (PK) com nomes únicos. Nada de toda PK com o nome ID</li>
	<li>Use VIEWS e/ou SubSelects</li>
	<li>Use tabelas de apoio, para os "tipos"</li>
</ul>