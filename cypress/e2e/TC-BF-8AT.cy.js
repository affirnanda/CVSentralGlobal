describe('TC-BF-8AT', () => {

    beforeEach(() => {
        cy.visit('/testing/isi-cart');
    });

    it('TC-BF-8AT Tanggal akhir sebelum tanggal mulai', () => { 
        cy.isiCheckoutRentValid(); 
        const start = new Date(); start.setDate(start.getDate() + 5); 
        const end = new Date(); end.setDate(end.getDate() + 3); 
        cy.get('input[name="rent_start"]') .clear() .type(start.toISOString().split('T')[0]); 
        cy.get('input[name="rent_end"]') .clear() .type(end.toISOString().split('T')[0]); 
        cy.get('button[type="submit"]').click(); 
        cy.contains('Tanggal akhir harus setelah tanggal mulai'); });

});