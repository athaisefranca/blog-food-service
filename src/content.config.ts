import { defineCollection, z } from 'astro:content';
import { glob } from 'astro/loaders';

const categorySlugs = [
  'gestao-e-operacao',
  'margem-lucro-e-numeros',
  'cardapio-e-produto',
  'marketing-e-posicionamento',
  'presenca-digital-e-canais-de-venda',
  'tendencias-tecnologia-e-mercado',
] as const;

const segmentSlugs = [
  'restaurantes',
  'hamburguerias',
  'cafeterias',
  'confeitarias',
  'pizzarias',
  'bares',
  'deliverys',
  'dark-kitchens',
] as const;

const contentTypeSlugs = [
  'guia-completo',
  'artigo-educativo',
  'checklist',
  'diagnostico',
  'analise-estrategica',
  'comparativo',
  'glossario',
  'estudo-hipotetico',
] as const;

const ctaIds = [
  'newsletter',
  'diagnostico-operacao',
  'whatsapp-consultoria',
  'material-gratuito',
] as const;

const posts = defineCollection({
  loader: glob({
    pattern: '**/*.{md,mdx}',
    base: './src/content/posts',
  }),
  schema: z.object({
    title: z.string(),
    description: z.string(),
    slug: z.string(),

    category: z.enum(categorySlugs),
    segments: z.array(z.enum(segmentSlugs)).default([]),
    tags: z.array(z.string()).default([]),

    author: z.string(),
    pubDate: z.coerce.date(),
    updatedDate: z.coerce.date(),

    status: z.enum(['draft', 'published', 'archived']).default('draft'),

    featuredImage: z.string(),
    featuredImageAlt: z.string(),

    primaryKeyword: z.string(),
    secondaryKeywords: z.array(z.string()).default([]),

    funnelStage: z.enum(['topo', 'meio', 'fundo']),
    contentType: z.enum(contentTypeSlugs),

    cta: z.enum(ctaIds).default('newsletter'),
    leadMagnet: z.string().optional(),

    faq: z.boolean().default(false),
    hasChecklist: z.boolean().default(false),
    hasExamplesBySegment: z.boolean().default(false),

    canonical: z.string().optional(),
    noindex: z.boolean().default(false),
    isPillar: z.boolean().default(false),

    relatedPosts: z.array(z.string()).default([]),
  }),
});

export const collections = {
  posts,
};