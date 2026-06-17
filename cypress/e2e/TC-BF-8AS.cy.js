describe('TC-BF-8AS', () => {

    beforeEach(() => {
        cy.visit('/testing/isi-cart');
    });

    it('TC-BF-8AS Tanggal akhir sama dengan tanggal mulai', () => { 
        cy.isiCheckoutRentValid(); const date = new Date(); 
        date.setDate(date.getDate() + 1); const sameDate = date.toISOString().split('T')[0]; 
        cy.get('input[name="rent_start"]') .clear() .type(sameDate); 
        cy.get('input[name="rent_end"]') .clear() .type(sameDate); 
        cy.get('button[type="submit"]').click(); 
        cy.contains('Tanggal akhir harus setelah tanggal mulai'); 
    });

});