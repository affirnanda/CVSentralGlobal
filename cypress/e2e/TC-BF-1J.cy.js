describe('TC-BF-1J: Admin mengunggah gambar konten section', () => {
  it('Admin mengunggah gambar profil valid', () => {
    cy.visit('/login');
    cy.get('input#email').type('super@admin.com');
    cy.get('input#password').type('admin123');
    cy.get('button[type="submit"]').click();
    cy.visit('/admin/kelola-hero-section');
    cy.get('input[name="hero_title"]').clear().type('Solusi Terbaik');
    cy.get('textarea[name="section_text"], input[name="section_text"]').clear().type('Deskripsi Hero');
    cy.get('input[type="file"][name="profile_image"]').selectFile({
      contents: Cypress.Buffer.from('dummy image'),
      fileName: 'profile.jpg',
      mimeType: 'image/jpeg'
    });
    cy.get('button[type="submit"]').click();
    cy.screenshot('TC-BF-1J');
  });
});