export const ctas = [
  {
    id: 'newsletter',
    title: 'Receba novos conteúdos sobre gestão e marketing para negócios de alimentação',
    type: 'newsletter',
  },
  {
    id: 'diagnostico-operacao',
    title: 'Faça um diagnóstico da operação e presença digital do seu negócio',
    type: 'diagnostic',
  },
  {
    id: 'whatsapp-consultoria',
    title: 'Fale com a Thaise França no WhatsApp',
    type: 'whatsapp',
  },
  {
    id: 'material-gratuito',
    title: 'Baixe um material gratuito',
    type: 'lead-magnet',
  },
] as const;

export type CtaId = (typeof ctas)[number]['id'];