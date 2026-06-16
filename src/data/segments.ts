export const segments = [
  {
    title: 'Para Restaurantes',
    slug: 'restaurantes',
    description:
      'Conteúdos aplicados à realidade de restaurantes, operação de salão, cardápio, equipe, margem e presença digital.',
  },
  {
    title: 'Para Hamburguerias',
    slug: 'hamburguerias',
    description:
      'Conteúdos para hamburguerias que precisam melhorar vendas, margem, delivery, cardápio e posicionamento.',
  },
  {
    title: 'Para Cafeterias',
    slug: 'cafeterias',
    description:
      'Conteúdos para cafeterias que querem aumentar ticket médio, recorrência, experiência e presença local.',
  },
  {
    title: 'Para Confeitarias',
    slug: 'confeitarias',
    description:
      'Conteúdos para confeitarias sobre encomendas, precificação, produção, cardápio, Instagram e margem.',
  },
  {
    title: 'Para Bares',
    slug: 'bares',
    description:
      'Conteúdos para bares sobre datas comerciais, experiência, atendimento, cardápio, eventos e vendas.',
  },
  {
    title: 'Para Deliverys',
    slug: 'deliverys',
    description:
      'Conteúdos para operações de delivery sobre canais de venda, iFood, embalagem, recompra e margem.',
  },
  {
    title: 'Para Dark Kitchens',
    slug: 'dark-kitchens',
    description:
      'Conteúdos para dark kitchens sobre operação enxuta, cardápio, canais digitais, produção e crescimento.',
  },
  {
  title: 'Para Pizzarias',
  slug: 'pizzarias',
  description:
    'Conteúdos para pizzarias sobre ficha técnica, CMV, precificação, delivery, cardápio, combos, margem e presença local.',
  },
] as const;

export type SegmentSlug = (typeof segments)[number]['slug'];
