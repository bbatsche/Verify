#!/usr/bin/env ruby
Encoding.default_external = Encoding::UTF_8
Encoding.default_internal = Encoding::UTF_8

message_file = ARGV[0]
message = File.read(message_file)

if message.downcase.start_with? 'merge'
  # Don't enforce issue numbers on merges
  exit 0
end

$regex = /#(\d+)/

if !$regex.match(message)
  puts "Rejected: All commits must relate to GitHub issues."
  exit 1
end
