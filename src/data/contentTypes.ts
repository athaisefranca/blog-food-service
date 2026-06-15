export const contentTypes = [
  {
    title: 'Guia completo',
    slug: 'guia-completo',
  },
  {
    title: 'Artigo educativo',
    slug: 'artigo-educativo',
  },
  {
    title: 'Checklist',
    slug: 'checklist',
  },
  {
    title: 'Diagnóstico',
    slug: 'diagnostico',
  },
  {
    title: 'Análise estratégica',
    slug: 'analise-estrategica',
  },
  {
    title: 'Comparativo',
    slug: 'comparativo',
  },
  {
    title: 'Glossário',
    slug: 'glossario',
  },
  {
    title: 'Estudo hipotético',
    slug: 'estudo-hipotetico',
  },
] as const;

export type ContentTypeSlug = (typeof contentTypes)[number]['slug'];
