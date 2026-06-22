describe('TC-BF-1H: Admin menyimpan paragraf konten section (>255 karakter)', () => {
  it('Admin menyimpan paragraf konten section >255 karakter', () => {
    cy.visit('/login');
    cy.get('input#email').type('super@admin.com');
    cy.get('input#password').type('admin123');
    cy.get('button[type="submit"]').click({force: true});
    cy.visit('/admin/kelola-hero-section');
    cy.get('input[name="hero_title"]').clear({force: true}).type('Solusi Terbaik');
    cy.get('textarea[name="section_text"], input[name="section_text"]').clear({force: true}).type('C'.repeat(256));
    cy.get('button[type="submit"]').click({force: true});
    cy.screenshot('TC-BF-1H');
  });
});