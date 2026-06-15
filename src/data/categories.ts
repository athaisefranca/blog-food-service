export const categories = [
  {
    title: 'Gestão e Operação',
    slug: 'gestao-e-operacao',
    description:
      'Conteúdos sobre rotina, equipe, processos, atendimento, produção, organização e operação de negócios de alimentação.',
  },
  {
    title: 'Margem, Lucro e Números',
    slug: 'margem-lucro-e-numeros',
    description:
      'Conteúdos sobre CMV, ficha técnica, precificação, margem, ponto de equilíbrio, caixa e indicadores.',
  },
  {
    title: 'Cardápio e Produto',
    slug: 'cardapio-e-produto',
    description:
      'Conteúdos sobre cardápio, produtos, combos, mix de venda, engenharia de cardápio e percepção de valor.',
  },
  {
    title: 'Marketing e Posicionamento',
    slug: 'marketing-e-posicionamento',
    description:
      'Conteúdos sobre marca, desejo, diferenciação, campanhas, comunicação e estratégia comercial.',
  },
  {
    title: 'Presença Digital e Canais de Venda',
    slug: 'presenca-digital-e-canais-de-venda',
    description:
      'Conteúdos sobre Instagram, Google, WhatsApp, iFood, delivery próprio, landing pages e canais digitais.',
  },
  {
    title: 'Tendências, Tecnologia e Mercado',
    slug: 'tendencias-tecnologia-e-mercado',
    description:
      'Conteúdos sobre novidades, tecnologia, comportamento de consumo, mercado food service e oportunidades.',
  },
] as const;

export type CategorySlug = (typeof categories)[number]['slug'];
