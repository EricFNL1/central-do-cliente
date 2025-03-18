<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />
  <title>Nossos Produtos</title>
  <style>
    /* Reset básico */
    html {
  scroll-behavior: smooth;
}

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      color: #333;
      line-height: 1.5;
    }

    /* Cabeçalho (Header) */
    header {
      background-color: #fff;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      position: sticky;
      top: 0;
      z-index: 999;
    }

    .navbar {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 60px;
    }

    .navbar .logo {
      font-size: 1.5rem;
      font-weight: bold;
      color: #;
    }

    .navbar ul {
      list-style: none;
      display: flex;
      gap: 20px;
    }

    .navbar ul li a {
      text-decoration: none;
      color: #333;
      font-size: 0.95rem;
      transition: color 0.3s;
    }

    .pointc:hover{
        color: #22bbd9;
    }
    .pointid:hover{
        color:rgb(88, 202, 132)
    }
    .pointsaas:hover{
        color:rgb(243, 140, 22)
    }

    /*.navbar ul li a:hover {
      color: #22bbd9;
    }
*/
    /* Seção Hero (Banner) */
    .hero {
      background: url('img/33296b.png') no-repeat center center / cover;
      height: 400px;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: #fff;
      position: relative;
    }

    .hero::before {
      content: "";
      position: absolute;
      top: 0; right: 0; bottom: 0; left: 0;
      background: rgba(0, 0, 0, 0.4); /* Escurece o banner para melhorar a leitura do texto */
    }

    .hero-content {
      position: relative; /* Para que o texto fique acima do overlay */
      max-width: 800px;
      padding: 0 20px;
    }

    .hero-content h1 {
      font-size: 2.5rem;
      margin-bottom: 20px;
    }

    .hero-content p {
      font-size: 1.1rem;
      margin-bottom: 30px;
    }

    .hero-content a {
      display: inline-block;
      background: #007bff;
      color: #fff;
      padding: 12px 24px;
      border-radius: 4px;
      text-decoration: none;
      font-weight: bold;
      transition: background 0.3s;
    }

    .hero-content a:hover {
      background: #0056b3;
    }

    /* Seção de Produtos */
    .produtos-section {
      max-width: 1200px;
      margin: 40px auto;
      padding: 0 20px;
    }

    .produtos-section h2 {
      text-align: center;
      font-size: 2rem;
      margin-bottom: 30px;
    }

    .produtos {
      display: flex;
      flex-wrap: wrap;
      gap: 40px;
      justify-content: center;
    }

    .produto {
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      padding: 20px;
      text-align: center;
      width: 280px;
      transition: transform 0.2s ease;
    }

    .produto:hover {
      transform: translateY(-5px);
    }

    .produto h3 {
      margin-bottom: 10px;
      font-size: 1.4rem;
    }

    /* Classes de cor para os nomes */
    .pcond {
        color: #22bbd9
    }

    .pid {
        color:rgb(88, 202, 132)
    }

    .psaas {
        color:rgb(243, 140, 22)
    }

    .produto p {
      font-size: 0.95rem;
      line-height: 1.4;
      margin-bottom: 15px;
    }

    .produto ul {
      list-style: disc;
      text-align: left;
      margin: 0 auto 15px auto;
      padding-left: 20px;
      max-width: 220px;
      font-size: 0.9rem;
    }

    .produto a {
      display: inline-block;
      background: #007bff;
      color: #fff;
      padding: 8px 16px;
      border-radius: 4px;
      text-decoration: none;
      font-weight: bold;
      font-size: 0.9rem;
      transition: background 0.3s;
    }

    .produto a:hover {
      background: #0056b3;
    }

    /* Seção de Call To Action */
    .cta-section {
      background: #22bbd9;
      color: #fff;
      padding: 40px 20px;
      text-align: center;
      margin: 40px 0;
    }

    .cta-section h2 {
      font-size: 2rem;
      margin-bottom: 20px;
    }

    .cta-section p {
      font-size: 1rem;
      margin-bottom: 20px;
    }

    .cta-section a {
      display: inline-block;
      background: #fff;
      color: #007bff;
      padding: 12px 24px;
      border-radius: 4px;
      text-decoration: none;
      font-weight: bold;
      transition: background 0.3s, color 0.3s;
    }

    .cta-section a:hover {
      background: #0056b3;
      color: #fff;
    }

    /* Rodapé (Footer) */
    footer {
      background: #fff;
      box-shadow: 0 -2px 4px rgba(0,0,0,0.1);
      padding: 20px 0;
    }

    .footer-content {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: flex-start;
      gap: 30px;
    }

    .footer-content div {
      flex: 1;
      min-width: 200px;
    }

    .footer-content h4 {
      margin-bottom: 15px;
      font-size: 1.2rem;
    }

    .footer-content p, .footer-content ul {
      font-size: 0.9rem;
    }

    .footer-content ul {
      list-style: none;
      padding-left: 0;
    }

    .footer-content ul li {
      margin-bottom: 5px;
    }

    .footer-bottom {
      text-align: center;
      margin-top: 20px;
      font-size: 0.85rem;
      color: #777;
    }

    /* Responsividade */
    @media (max-width: 768px) {
      .produtos {
        flex-direction: column;
        align-items: center;
      }

      .produto {
        width: 100%;
        max-width: 400px;
      }

      .navbar ul {
        display: none; /* Exemplo simples: esconde menu no mobile */
      }
    }
  </style>
</head>
<body>

  <!-- Cabeçalho com Navegação -->
  <header>
    <nav class="navbar">
      <div class="logo">Point Produtos</div>
      <ul>
        <li><a href="#" class="pointc">PointCondominio</a></li>
        <li><a href="#" class="pointid">PointID</a></li>
        <li><a href="#" class="pointsaas">PointSaaS</a></li>
        <li><a href="#">Contato</a></li>
      </ul>
    </nav>
  </header>

  <!-- Seção Hero -->
  <section class="hero">
    <div class="hero-content">
      <h1>Conheça Nossos Produtos</h1>
      <p>Soluções inovadoras para gestão de condomínios, identificação e infraestrutura em nuvem.</p>
      <a href="#produtos">Saiba Mais</a>
    </div>
  </section>

  <!-- Seção de Produtos -->
  <section id="produtos" class="produtos-section">
    <h2>Nossos Produtos</h2>
    <div class="produtos">
      
      <!-- PointCondominio -->
      <div class="produto">
        <h3>Point<span class="pcond">Condominio</span></h3>
        <p>Plataforma especializada em gestão de condomínios, facilitando o controle e a comunicação entre síndicos, moradores e visitantes.</p>
        <ul>
          <li>Reserva de áreas comuns</li>
          <li>Gerenciamento de moradores</li>
          <li>Controle de visitantes</li>
          <li>Emissão de relatórios</li>
        </ul>
    <a href="https://www.pointcondominio.com.br" target="_blank">Ver detalhes</a>
      </div>

      <!-- PointID -->
      <div class="produto">
        <h3>Point<span class="pid">ID</span></h3>
        <p>Sistema de identificação e controle de acesso seguro, oferecendo autenticação multifatorial e integração com diversos aplicativos.</p>
        <ul>
          <li>Autenticação em dois fatores</li>
          <li>Gestão de usuários e permissões</li>
          <li>Integração com sistemas externos</li>
          <li>Alertas de segurança em tempo real</li>
        </ul>
        <a href="https://www.pointid.com.br" target="_blank">Ver detalhes</a>
      </div>

      <!-- PointSaaS -->
      <div class="produto">
        <h3>Point<span class="psaas">SaaS</span></h3>
        <p>Serviço em nuvem que oferece soluções escaláveis para empresas, reduzindo custos de infraestrutura e facilitando a implantação de software.</p>
        <ul>
          <li>Escalabilidade automática</li>
          <li>Suporte a múltiplos ambientes</li>
          <li>Alta disponibilidade</li>
          <li>Redução de custos de TI</li>
        </ul>
        <a href="https://www.pointsaas.com.br" target=" _blank">Ver detalhes</a>
      </div>

    </div>
  </section>

  <!-- Seção de Call To Action -->
  <section class="cta-section">
    <h2>Pronto para modernizar o seu negócio?</h2>
    <p>Entre em contato conosco e descubra como nossas soluções podem acelerar a sua transformação digital.</p>
    <a href="#">Fale Conosco</a>
  </section>

  <!-- Rodapé -->
  <footer>
    <div class="footer-content">
      <div>
        <h4>SuaEmpresa</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vel sapien nec diam molestie consequat. Donec maximus congue semper.</p>
      </div>
      <div>
        <h4>Links Úteis</h4>
        <ul>
          <li><a href="#">Início</a></li>
          <li><a href="#">Sobre Nós</a></li>
          <li><a href="#">Serviços</a></li>
          <li><a href="#">Produtos</a></li>
          <li><a href="#">Contato</a></li>
        </ul>
      </div>
      <div>
        <h4>Contato</h4>
        <p>Endereço: Rua Exemplo, 123<br>
        Cidade - Estado - País</p>
        <p>Telefone: (99) 9999-9999</p>
        <p>E-mail: contato@suaempresa.com</p>
      </div>
    </div>
    <div class="footer-bottom">
      &copy; 2025 - SuaEmpresa. Todos os direitos reservados.
    </div>
  </footer>

</body>
</html>
