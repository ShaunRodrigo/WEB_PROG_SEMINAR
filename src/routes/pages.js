const express = require('express');
const router = express.Router();
const pageController = require('../controllers/pageController');
const { ensureAuthenticated } = require('../middleware/auth');
const { ensureAdmin } = require('../middleware/admin');
const db = require('../config/db');



router.get('/database', ensureAuthenticated, pageController.databasePage);


router.get('/', (req, res) => {
  res.render('index', { user: req.user || null });
});

router.get('/admin', ensureAdmin, (req, res) => {
  res.render('admin', { user: req.user });
});


router.post('/contact', async (req, res) => {
  const { firstName, lastName, message } = req.body;

  try {
    await db.query(
      'INSERT INTO contact_messages (first_name, last_name, message) VALUES (?, ?, ?)',
      [firstName, lastName, message]
    );

    req.flash('success_msg', 'Message sent successfully!');
    res.redirect('/');
  } catch (err) {
    console.error(err);
    req.flash('error_msg', 'Failed to send message.');
    res.redirect('/');
  }
});

router.get('/messages', ensureAuthenticated, async (req, res) => {
  try {
    const [rows] = await db.query(
      'SELECT * FROM contact_messages ORDER BY created_at DESC'
    );
    res.render('messages', { user: req.user, messages: rows });
  } catch (err) {
    console.error(err);
    req.flash('error_msg', 'Could not load messages');
    res.redirect('/');
  }
});



module.exports = router;
